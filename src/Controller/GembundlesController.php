<?php

namespace App\Controller;

use App\Entity\Gembundles;
use App\Form\GembundlesType;
use App\Repository\GembundlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EntityLoggerService;
use Symfony\Component\HttpFoundation\File\Exception\FileException; // Add this import

#[Route('/gembundles')]
final class GembundlesController extends AbstractController
{
    #[Route(name: 'app_gembundles_index' , methods: ['GET'])]
    public function index(GembundlesRepository $repo): Response
    {
        return $this->render('gembundles/index.html.twig', [
            'gembundles' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gembundles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        $gembundle = new Gembundles();
        $form = $this->createForm(GembundlesType::class, $gembundle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('bundles_images_directory'), $newFilename);
                    $gembundle->setImage('images/bundles/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image upload failed: ' . $e->getMessage());
                }
            }

            $gembundle->setCreatedAt(new \DateTimeImmutable());
            $em->persist($gembundle);
            $em->flush();

            // LOG CREATION
            $entityLogger->logCreate($gembundle);

            $this->addFlash('success', 'Gem bundle created successfully!');
            return $this->redirectToRoute('app_gembundles_index');
        }

        return $this->render('gembundles/new.html.twig', [
            'gembundle' => $gembundle,
            'form' => $form->createView(),  // Add ->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_gembundles_show', methods: ['GET'])]
    public function show(Gembundles $gembundle): Response
    {
        return $this->render('gembundles/show.html.twig', [
            'gembundle' => $gembundle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gembundles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gembundles $gembundle, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        $oldImage = $gembundle->getImage();
        $form = $this->createForm(GembundlesType::class, $gembundle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Delete old image if exists
                if ($oldImage && file_exists($this->getParameter('kernel.project_dir') . '/public/' . $oldImage)) {
                    @unlink($this->getParameter('kernel.project_dir') . '/public/' . $oldImage);
                }
                
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('bundles_images_directory'), $newFilename);
                    $gembundle->setImage('images/bundles/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image upload failed: ' . $e->getMessage());
                    $gembundle->setImage($oldImage);
                }
            } else {
                $gembundle->setImage($oldImage);
            }

            $em->flush();

            // LOG UPDATE
            $entityLogger->logUpdate($gembundle);

            $this->addFlash('success', 'Gem bundle updated successfully!');
            return $this->redirectToRoute('app_gembundles_index');
        }

        return $this->render('gembundles/edit.html.twig', [
            'gembundle' => $gembundle,
            'form' => $form->createView(),  // Add ->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_gembundles_delete', methods: ['POST'])]
    public function delete(Request $request, Gembundles $gembundle, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gembundle->getId(), $request->request->get('_token'))) {
            
            // LOG BEFORE deletion
            $entityLogger->logDelete($gembundle);
            
            // Delete image file
            if ($gembundle->getImage() && file_exists($this->getParameter('kernel.project_dir') . '/public/' . $gembundle->getImage())) {
                @unlink($this->getParameter('kernel.project_dir') . '/public/' . $gembundle->getImage());
            }

            $em->remove($gembundle);
            $em->flush();
            
            $this->addFlash('success', 'Gem bundle deleted successfully!');
        }

        return $this->redirectToRoute('app_gembundles_index');
    }
}