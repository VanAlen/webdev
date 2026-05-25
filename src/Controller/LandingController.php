<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\GemRepository;
use App\Repository\JewelriesRepository;

final class LandingController extends AbstractController
{
    #[Route('/', name: 'app_landing')]
    public function index(
        GemRepository $gemRepository,
        JewelriesRepository $jewelryRepository
    ): Response {
        // Get all gems and jewelries
        $gems = $gemRepository->findAll();
        $jewelries = $jewelryRepository->findAll();

        return $this->render('landing/index.html.twig', [
            'gems' => $gems,
            'jewelries' => $jewelries,
        ]);
    }
}