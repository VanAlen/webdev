<?php

namespace App\Controller;

use App\Entity\Customjewelries;
use App\Form\CustomjewelriesType;
use App\Repository\CustomjewelriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EntityLoggerService;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/customjewelries')]
class CustomjewelriesController extends AbstractController
{
    #[Route('/', name: 'app_customjewelries_index', methods: ['GET'])]
    public function index(CustomjewelriesRepository $repo): Response
    {
        return $this->render('customjewelries/index.html.twig', [
            'customjewelries' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_customjewelries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        // Check if user is logged in
        if (!$this->getUser()) {
            $this->addFlash('error', 'You are not logged in! Please log in to create custom jewelry.');
            return $this->redirectToRoute('login');
        }

        $customjewelry = new Customjewelries();
        $form = $this->createForm(CustomjewelriesType::class, $customjewelry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('imagepath')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                
                // Get the uploads directory from parameters
                $uploadsDir = $this->getParameter('uploads_directory');
                
                // Create directory if it doesn't exist
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0777, true);
                }
                
                // Move the uploaded file
                $imageFile->move($uploadsDir, $newFilename);
                $customjewelry->setImagepath('images/custom/'.$newFilename);
            }

            // Set creation info
            $customjewelry->setCreatedAt(new \DateTimeImmutable());
            $customjewelry->setCustomer($this->getUser());

            // Save to database
            $em->persist($customjewelry);
            $em->flush();

            // Log creation
            $entityLogger->logCreate($customjewelry);

            $this->addFlash('success', 'Custom jewelry created successfully!');
            return $this->redirectToRoute('app_customjewelries_index');
        }

        return $this->render('customjewelries/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_customjewelries_show', methods: ['GET'])]
    public function show(Customjewelries $customjewelry): Response
    {
        return $this->render('customjewelries/show.html.twig', [
            'customjewelry' => $customjewelry,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_customjewelries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Customjewelries $customjewelry, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        // Store old image path BEFORE form handling
        $oldImagePath = $customjewelry->getImagepath();
        
        $form = $this->createForm(CustomjewelriesType::class, $customjewelry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get changes for logging (do this before any modifications)
            $unitOfWork = $em->getUnitOfWork();
            $unitOfWork->computeChangeSets();
            $changes = $unitOfWork->getEntityChangeSet($customjewelry);
            
            // Handle image upload
            $imageFile = $form->get('imagepath')->getData();
            
            if ($imageFile) {
                // Delete old image if it exists
                if ($oldImagePath && file_exists($this->getParameter('kernel.project_dir').'/public/'.$oldImagePath)) {
                    try {
                        unlink($this->getParameter('kernel.project_dir').'/public/'.$oldImagePath);
                    } catch (\Exception $e) {
                        // Log error but continue
                        error_log('Error deleting old image: ' . $e->getMessage());
                    }
                }

                // Save new image
                try {
                    $newFilename = uniqid().'.'.$imageFile->guessExtension();
                    $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/images/custom';
                    
                    // Create directory if it doesn't exist
                    if (!is_dir($uploadsDir)) {
                        mkdir($uploadsDir, 0777, true);
                    }
                    
                    $imageFile->move($uploadsDir, $newFilename);
                    $customjewelry->setImagepath('images/custom/'.$newFilename);
                    
                    // Add image change to logging
                    $changes['imagepath'] = [$oldImagePath, $customjewelry->getImagepath()];
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Failed to upload image: ' . $e->getMessage());
                    return $this->redirectToRoute('app_customjewelries_edit', ['id' => $customjewelry->getId()]);
                }
            }
            
            // Only flush if we need to (entity might already be dirty)
            if ($em->getUnitOfWork()->isScheduledForUpdate($customjewelry) || $imageFile) {
                try {
                    $em->flush();
                    
                    // Log update
                    $entityLogger->logUpdate($customjewelry, $changes);
                    
                    $this->addFlash('success', 'Custom jewelry updated successfully!');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Failed to save changes: ' . $e->getMessage());
                    return $this->redirectToRoute('app_customjewelries_edit', ['id' => $customjewelry->getId()]);
                }
            } else {
                $this->addFlash('info', 'No changes were made.');
            }
            
            return $this->redirectToRoute('app_customjewelries_index');
        }

        // Debug: Check form errors
        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        return $this->render('customjewelries/edit.html.twig', [
            'form' => $form->createView(),
            'customjewelry' => $customjewelry,
        ]);
    }
    #[Route('/{id}/delete', name: 'app_customjewelries_delete', methods: ['POST'])]
    public function delete(Request $request, Customjewelries $customjewelry, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customjewelry->getId(), $request->request->get('_token'))) {

            // Log before deletion
            $entityLogger->logDelete($customjewelry);

            // Delete image file too
            if ($customjewelry->getImagepath() && file_exists($this->getParameter('kernel.project_dir').'/public/'.$customjewelry->getImagepath())) {
                unlink($this->getParameter('kernel.project_dir').'/public/'.$customjewelry->getImagepath());
            }

            // Remove from database
            $em->remove($customjewelry);
            $em->flush();

            $this->addFlash('success', 'Custom jewelry deleted successfully!');
        }

        return $this->redirectToRoute('app_customjewelries_index');
    }
}