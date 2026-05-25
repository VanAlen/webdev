<?php // src/Controller/JewelriesController.php
namespace App\Controller;

use App\Entity\Jewelries;
use App\Form\JewelriesType;
use App\Repository\JewelriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EntityLoggerService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/jewelries')]
class JewelriesController extends AbstractController
{
    #[Route(name: 'app_jewelries_index' , methods: ['GET'])]
    public function index(JewelriesRepository $repo): Response
    {
        return $this->render('jewelries/index.html.twig', [
            'jewelries' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_jewelries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        $jewelry = new Jewelries();
        $form = $this->createForm(JewelriesType::class, $jewelry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('jewelry_images_directory'), $newFilename);
                $jewelry->setImage('images/jewelries/' . $newFilename);
            }

            $em->persist($jewelry);
            $em->flush();

            // LOG CREATION
            $entityLogger->logCreate($jewelry);

            $this->addFlash('success', 'Jewelry created successfully!');
            return $this->redirectToRoute('app_jewelries_index');
        }

        return $this->render('jewelries/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_jewelries_show', methods: ['GET'])]
    public function show(Jewelries $jewelry): Response
    {
        return $this->render('jewelries/show.html.twig', [
            'jewelry' => $jewelry,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_jewelries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jewelries $jewelry, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        // Store original values before form submission
        $originalData = [
            'name' => $jewelry->getName(),
            'price' => $jewelry->getPrice(),
            'stock' => $jewelry->getStock(),
            'gemtype' => $jewelry->getGemtype() ? $jewelry->getGemtype()->getId() : null,
            'jewelrytype' => $jewelry->getJewelrytype() ? $jewelry->getJewelrytype()->getId() : null,
        ];
        
        $oldImage = $jewelry->getImage();
        
        $form = $this->createForm(JewelriesType::class, $jewelry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image')->getData();
            
            if ($imageFile) {
                // Delete old image if exists
                if ($oldImage && file_exists($this->getParameter('kernel.project_dir') . '/public/' . $oldImage)) {
                    @unlink($this->getParameter('kernel.project_dir') . '/public/' . $oldImage);
                }
                
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('jewelry_images_directory'), $newFilename);
                    $jewelry->setImage('images/jewelries/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image upload failed: ' . $e->getMessage());
                    $jewelry->setImage($oldImage); // Keep old image if upload fails
                }
            }
            
            // Save changes
            $em->flush();
            
            // Log update with changes
            $entityLogger->logUpdate($jewelry, $originalData);
            
            $this->addFlash('success', 'Jewelry updated successfully!');
            return $this->redirectToRoute('app_jewelries_index');
        }

        return $this->render('jewelries/edit.html.twig', [
            'form' => $form->createView(),
            'jewelry' => $jewelry,
        ]);
    }


    #[Route('/{id}', name: 'app_jewelries_delete', methods: ['POST'])]
    public function delete(Request $request, Jewelries $jewelry, EntityManagerInterface $em, EntityLoggerService $entityLogger): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jewelry->getId(), $request->request->get('_token'))) {
            
            // LOG BEFORE deletion
            $entityLogger->logDelete($jewelry);
            
            if ($jewelry->getImage() && file_exists($this->getParameter('kernel.project_dir') . '/public/' . $jewelry->getImage())) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $jewelry->getImage());
            }

            $em->remove($jewelry);
            $em->flush();
            
            $this->addFlash('success', 'Jewelry deleted successfully!');
        }

        return $this->redirectToRoute('app_jewelries_index');
    }
}