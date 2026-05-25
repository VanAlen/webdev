<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\EmailVerificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        EntityManagerInterface $entityManager,
        EmailVerificationService $emailVerificationService
    ): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            
            
            $user->setRoles(['ROLE_STAFF']);
            
            $verificationToken = $emailVerificationService->generateVerificationToken();
            $user->setVerificationToken($verificationToken);
            $user->setIsVerified(false);

            $entityManager->persist($user);
            $entityManager->flush();

            $verificationUrl = $this->generateUrl(
                'app_verify_email',
                ['token' => $verificationToken],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $emailVerificationService->sendVerificationEmail($user, $verificationUrl);

            $this->addFlash('success', 'Registration successful! Please check your email to verify your account.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    // ✅ ADD THIS ROUTE - Email verification
    #[Route('/verify-email/{token}', name: 'app_verify_email')]
    public function verifyEmail(string $token, EmailVerificationService $emailVerificationService): Response
    {
        $user = $emailVerificationService->verifyToken($token);
        
        if (!$user) {
            $this->addFlash('error', 'Invalid or expired verification token.');
            return $this->redirectToRoute('app_login');
        }
        
        $this->addFlash('success', 'Your email has been verified! You can now log in.');
        return $this->redirectToRoute('app_login');
    }

    // ✅ ADD THIS ROUTE - Resend verification email
    #[Route('/resend-verification', name: 'app_resend_verification')]
    public function resendVerification(Request $request, EntityManagerInterface $entityManager, EmailVerificationService $emailVerificationService): Response
    {
        $email = $request->query->get('email');
        
        if (!$email) {
            $this->addFlash('error', 'Email address is required.');
            return $this->redirectToRoute('app_login');
        }
        
        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
        
        if ($user && !$user->isVerified()) {
            if (!$user->getVerificationToken()) {
                $user->setVerificationToken($emailVerificationService->generateVerificationToken());
                $entityManager->flush();
            }
            
            $verificationUrl = $this->generateUrl(
                'app_verify_email',
                ['token' => $user->getVerificationToken()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            
            $emailVerificationService->sendVerificationEmail($user, $verificationUrl);
            $this->addFlash('success', 'Verification email has been resent. Please check your inbox.');
        } elseif ($user && $user->isVerified()) {
            $this->addFlash('info', 'This email is already verified. You can log in.');
        } else {
            $this->addFlash('error', 'No account found with this email address.');
        }
        
        return $this->redirectToRoute('app_login');
    }

    // ✅ ADD THIS ROUTE - Check email exists (for real-time validation)
    #[Route('/check-email', name: 'app_check_email', methods: ['POST'])]
    public function checkEmail(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        
        if (!$email) {
            return $this->json(['exists' => false, 'message' => 'No email provided'], 400);
        }
        
        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
        
        return $this->json([
            'exists' => $user !== null,
            'isVerified' => $user ? $user->isVerified() : false
        ]);
    }
}