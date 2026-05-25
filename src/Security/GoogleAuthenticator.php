<?php

namespace App\Security;

use App\Entity\User;
use App\Service\EmailVerificationService;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private EntityManagerInterface $entityManager,
        private RouterInterface $router,
        private EmailVerificationService $emailVerificationService  // ADD THIS
    ) {}

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_google_check';
    }

    public function authenticate(Request $request): Passport
    {
        $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
        $client = $this->clientRegistry->getClient('google');
        $provider = $client->getOAuth2Provider();
        $provider->setHttpClient($guzzleClient);
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function() use ($accessToken, $client) {
                $googleUser = $client->fetchUserFromToken($accessToken);
                $userData = $googleUser->toArray();
                $email = $userData['email'] ?? null;
                $name = $userData['name'] ?? null;

                if (!$email) {
                    throw new AuthenticationException('Email not provided by Google');
                }

                $user = $this->entityManager->getRepository(User::class)
                    ->findOneBy(['email' => $email]);

                if (!$user) {
                    $baseUsername = $name ?: explode('@', $email)[0];
                    $username = $baseUsername;
                    $counter = 1;
                    
                    while ($this->entityManager->getRepository(User::class)
                        ->findOneBy(['username' => $username])) {
                        $username = $baseUsername . $counter;
                        $counter++;
                    }
                    
                    $user = new User();
                    $user->setEmail($email);
                    $user->setUsername($username);
                    $user->setPassword('');
                    $user->setRoles(['ROLE_STAFF']);
                    $user->setIsVerified(true);
                    $user->setVerificationToken(null);
                    
                    $this->entityManager->persist($user);
                    $this->entityManager->flush(); // CRITICAL: Flush here BEFORE returning
                }

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('app_dashboard'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse($this->router->generate('app_login'));
    }
}