<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EmailVerificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AuthController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        EmailVerificationService $emailVerificationService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            return $this->json(['message' => 'Username, email, and password required'], Response::HTTP_BAD_REQUEST);
        }

        // Check if username exists
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['username' => $data['username']]);
        if ($existingUser) {
            return $this->json(['message' => 'Username already exists'], Response::HTTP_CONFLICT);
        }

        // Check if email exists
        $existingEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingEmail) {
            return $this->json(['message' => 'Email already registered'], Response::HTTP_CONFLICT);
        }

        // Create new user
        $user = new User();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_STAFF']);
        $user->setStatus('active');

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Generate verification token
        $verificationToken = $emailVerificationService->generateVerificationToken();
        $user->setVerificationToken($verificationToken);
        $user->setIsVerified(false);

        $entityManager->persist($user);
        $entityManager->flush();

        // Generate verification URL
        $verificationUrl = $this->generateUrl(
            'app_verify_email',
            ['token' => $verificationToken],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        // Send verification email
        try {
            $emailVerificationService->sendVerificationEmail($user, $verificationUrl);
        } catch (\Exception $e) {
            // Log error
        }

        return $this->json([
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'isVerified' => $user->isVerified()
            ]
        ], Response::HTTP_CREATED);
    }
}