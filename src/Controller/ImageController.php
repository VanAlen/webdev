<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/image/{type}/{filename}', name: 'app_image')]
    public function show(string $type, string $filename): Response
    {
        $path = $this->getParameter('kernel.project_dir') . '/public/images/' . $type . '/' . $filename;
        
        if (!file_exists($path)) {
            throw $this->createNotFoundException('Image not found');
        }
        
        $response = new BinaryFileResponse($path);
        return $response;
    }
}