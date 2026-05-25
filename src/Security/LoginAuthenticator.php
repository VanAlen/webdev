<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Service\EmailVerificationService;
class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UrlGeneratorInterface $urlGenerator,
        private EmailVerificationService $emailVerificationService  // ADD THIS LINE
    ) {
    }

    
        public function authenticate(Request $request): Passport
        {
            $usernameOrEmail = $request->request->get('username', '');
            $password = $request->request->get('password', '');
            $csrfToken = $request->request->get('_csrf_token');

            $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $usernameOrEmail);

            return new Passport(
                new UserBadge($usernameOrEmail, function($userIdentifier) {
                    // Try to find by username first
                    $user = $this->entityManager->getRepository(User::class)
                        ->findOneBy(['username' => $userIdentifier]);
                    
                    // If not found, try by email
                    if (!$user) {
                        $user = $this->entityManager->getRepository(User::class)
                            ->findOneBy(['email' => $userIdentifier]);
                    }
                    
                    if (!$user) {
                        throw new AuthenticationException('Invalid credentials.');
                    }
                    
                    // Check if verified
                    if (!$user->isVerified()) {
                        throw new AuthenticationException('Please verify your email before logging in.');
                    }
                    
                    return $user;
                }),
                new PasswordCredentials($password),
                [
                    new CsrfTokenBadge('authenticate', $csrfToken),
                ]
            );
        }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_profile'));
    }

public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
{
    // Get what the user typed in the login form
    $enteredUsername = $request->getSession()->get(SecurityRequestAttributes::LAST_USERNAME);
    
    if ($enteredUsername) {
        // Find user by what they typed (can be username OR email)
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['username' => $enteredUsername]);
        
        if (!$user) {
            $user = $this->entityManager->getRepository(User::class)
                ->findOneBy(['email' => $enteredUsername]);
        }
        
        // If unverified, send email automatically
        if ($user && !$user->isVerified()) {
            $token = $this->emailVerificationService->generateVerificationToken();
            $user->setVerificationToken($token);
            $this->entityManager->flush();
            
            $verificationUrl = $this->urlGenerator->generate('app_verify_email', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
            $this->emailVerificationService->sendVerificationEmail($user, $verificationUrl);
        }
    }
    
    $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
    return new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));
}


    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}