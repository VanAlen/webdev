<?php

namespace App\Controller;

use App\Entity\Gem;
use App\Form\GemsType;
use App\Repository\GemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\ActivityLogger;

#[Route('/gem')]
final class GemController extends AbstractController
{
    #[Route( name: 'app_gem_index' , methods: ['GET'])]
    public function index(GemRepository $gemRepository): Response
    {
        return $this->render('gem/index.html.twig', [
            'gems' => $gemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gem_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, ActivityLogger $activityLogger): Response
    {
        $gem = new Gem();
        $form = $this->createForm(GemsType::class, $gem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imagepath')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('gems_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Upload failed: ' . $e->getMessage());
                }
                $gem->setImagepath('images/gems/' . $newFilename);
            }

            $entityManager->persist($gem);
            $entityManager->flush();

            // Log creation
            $activityLogger->log(
                'CREATE',
                sprintf('Gem: %s (ID: %d, Type: %s)', 
                    $gem->getDescription() ?: 'Untitled',
                    $gem->getId(),
                    $gem->getGemtype() ? $gem->getGemtype()->getName() : 'No type'
                )
            );

            $this->addFlash('success', 'Gem created successfully!');
            return $this->redirectToRoute('app_gem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gem/new.html.twig', [
            'gem' => $gem,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_gem_show', methods: ['GET'])]
    public function show(Gem $gem): Response
    {
        return $this->render('gem/show.html.twig', [
            'gem' => $gem,
        ]);
    }



    
    #[Route('/{id}/edit', name: 'app_gem_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gem $gem, EntityManagerInterface $entityManager, SluggerInterface $slugger, ActivityLogger $activityLogger): Response
    {
        // Store original values
        $originalPrice = $gem->getPrice();
        $oldImage = $gem->getImagepath();
        
        $form = $this->createForm(GemsType::class, $gem);
        
        // DEBUG: Add this line to see what's happening
        if ($request->isMethod('POST')) {
            dump([
                'request_data' => $request->request->all(),
                'files_data' => $request->files->all()
            ]);
            // die(); // Uncomment this to stop and see the data
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('imagepath')->getData();
            
            if ($imageFile) {
                // Delete old image if exists
                if ($oldImage && file_exists($this->getParameter('kernel.project_dir') . '/public/' . $oldImage)) {
                    @unlink($this->getParameter('kernel.project_dir') . '/public/' . $oldImage);
                }
                
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                
                try {
                    $imageFile->move(
                        $this->getParameter('gems_directory'),
                        $newFilename
                    );
                    $gem->setImagepath('images/gems/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image upload failed: ' . $e->getMessage());
                    $gem->setImagepath($oldImage);
                }
            }
            
            // Get new values
            $newPrice = $form->get('price')->getData();
            $priceChanged = ($originalPrice != $newPrice);
            
            // Save to database
            $entityManager->flush();
            
            // Log activity
            $changes = [];
            if ($priceChanged) {
                $changes[] = sprintf('price: $%s → $%s', $originalPrice, $newPrice);
            }
            if ($imageFile) {
                $changes[] = 'image: updated';
            }
            
            $activityLogger->log(
                'UPDATE',
                sprintf('Gem: %s (ID: %d) - Changes: %s', 
                    $gem->getDescription() ?: 'Untitled',
                    $gem->getId(),
                    $changes ? implode(', ', $changes) : 'none'
                )
            );
            
            $this->addFlash('success', 'Gem updated successfully!');
            return $this->redirectToRoute('app_gem_index', [], Response::HTTP_SEE_OTHER);
        }
        
        // If form is submitted but invalid, show errors
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        }
        
        return $this->render('gem/edit.html.twig', [
            'form' => $form->createView(),
            'gem' => $gem,
        ]);
    }





    #[Route('/{id}', name: 'app_gem_delete', methods: ['POST'])]
    public function delete(Request $request, Gem $gem, EntityManagerInterface $entityManager, ActivityLogger $activityLogger): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gem->getId(), $request->request->get('_token'))) {
            
            // Log deletion
            $activityLogger->log(
                'DELETE',
                sprintf('Gem: %s (ID: %d, Type: %s)', 
                    $gem->getDescription() ?: 'Untitled',
                    $gem->getId(),
                    $gem->getGemtype() ? $gem->getGemtype()->getName() : 'No type'
                )
            );
            
            $entityManager->remove($gem);
            $entityManager->flush();
            
            $this->addFlash('success', 'Gem deleted successfully!');
        }

        return $this->redirectToRoute('app_gem_index', [], Response::HTTP_SEE_OTHER);
    }
}