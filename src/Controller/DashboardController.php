<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')] // This ensures only logged-in users can access
    public function index(): Response
    {
        $user = $this->getUser();
        
        // Render a proper template instead of raw HTML
        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'user_roles' => $user->getRoles(),
        ]);
    }
}