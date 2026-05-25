<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/api/contact', name: 'api_contact', methods: ['POST'])]
    public function sendContact(Request $request, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $subject = $data['subject'] ?? 'Contact Form Message';
        $message = $data['message'] ?? '';
        
        // DEBUG: Log everything
        error_log('=== CONTACT FORM DEBUG ===');
        
        // Get logged-in user
        $user = $this->getUser();
        error_log('User from token: ' . ($user ? $user->getUserIdentifier() : 'NULL'));
        
        // Try to find user by email from form data
        $userByEmail = null;
        if ($email) {
            $userByEmail = $this->entityManager->getRepository(User::class)
                ->findOneBy(['email' => $email]);
            error_log('User found by email: ' . ($userByEmail ? $userByEmail->getUserIdentifier() : 'NULL'));
            if ($userByEmail) {
                error_log('User roles: ' . json_encode($userByEmail->getRoles()));
            }
        }
        
        $userRole = 'Guest (Not logged in)';
        
        // Use user from token or from email
        $activeUser = $user ?: $userByEmail;
        
        if ($activeUser) {
            $roles = $activeUser->getRoles();
            if (in_array('ROLE_ADMIN', $roles)) {
                $userRole = 'ADMIN';
            } elseif (in_array('ROLE_STAFF', $roles)) {
                $userRole = 'STAFF';
            } else {
                $userRole = 'USER';
            }
        }
        
        error_log('Final user role: ' . $userRole);
        
        if (!$name || !$email || !$message) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }
        
        try {
            // Send to admin with role information
            $adminEmail = (new Email())
                ->from('admingemz@gmail.com')
                ->to('admingemz@gmail.com')
                ->replyTo($email)
                ->subject('Contact Form: ' . $subject)
                ->html("
                    <h2>New Contact Message</h2>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>User Role:</strong> $userRole</p>
                    <p><strong>Subject:</strong> $subject</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                    <hr>
                    <p>Sent from Gemz Crystalline website</p>
                ");
            
            $mailer->send($adminEmail);
            
            // Send auto-reply to user
            $userEmail = (new Email())
                ->from('admingemz@gmail.com')
                ->to($email)
                ->subject('Thank you for contacting Gemz Crystalline')
                ->html("
                    <h2>Thank you for reaching out, $name!</h2>
                    <p>We have received your message and will get back to you within 24-48 hours.</p>
                    <br>
                    <p><strong>Your message:</strong></p>
                    <p>$message</p>
                    <br>
                    <p>Best regards,<br>Gemz Crystalline Team</p>
                ");
            
            $mailer->send($userEmail);
            
            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to send message: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/test-email', name: 'test_email')]
    public function testEmail(MailerInterface $mailer): Response
    {
        try {
            $email = (new Email())
                ->from('admingemz@gmail.com')
                ->to('admingemz@gmail.com')
                ->subject('Test Email from Symfony')
                ->html('<p>This is a test email sent at ' . date('Y-m-d H:i:s') . '</p>');
            
            $mailer->send($email);
            return new Response('✅ Email sent successfully! Check admingemz@gmail.com');
        } catch (\Exception $e) {
            return new Response('❌ Error: ' . $e->getMessage());
        }
    }
}