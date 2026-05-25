<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    #[Route('/connect/google', name: 'connect_google_start')]
    public function connect(ClientRegistry $clientRegistry): Response
    {
        // Redirect to Google login page
        return $clientRegistry->getClient('google')->redirect(
            ['email', 'profile'],  // Scopes
            []                      // Additional parameters (empty)
        );
    }

    #[Route('/connect/google/check', name: 'app_google_check')]
    public function check(): Response
    {
        // This route is handled by GoogleAuthenticator
        // If you get here, something went wrong
        return $this->redirectToRoute('app_login');
    }
}