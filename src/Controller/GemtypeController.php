<?php

namespace App\Controller;

use App\Entity\Gemtype;
use App\Form\GemtypeType;
use App\Repository\GemtypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gemtype')]
final class GemtypeController extends AbstractController
{
    #[Route(name: 'app_gemtype_index', methods: ['GET'])]
    public function index(GemtypeRepository $gemtypeRepository): Response
    {
        return $this->render('gemtype/index.html.twig', [
            'gemtypes' => $gemtypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gemtype_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gemtype = new Gemtype();
        $form = $this->createForm(GemtypeType::class, $gemtype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gemtype);
            $entityManager->flush();
            
            $this->addFlash('success', 'Gem type added!');

            // Redirect to gem creation page
            return $this->redirectToRoute('app_gem_new');
        }

        return $this->render('gemtype/new.html.twig', [
            'gemtype' => $gemtype,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gemtype_show', methods: ['GET'])]
    public function show(Gemtype $gemtype): Response
    {
        return $this->render('gemtype/show.html.twig', [
            'gemtype' => $gemtype,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gemtype_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gemtype $gemtype, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GemtypeType::class, $gemtype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Gem type updated!');

            // Redirect to gem creation page
            return $this->redirectToRoute('app_gem_new');
        }

        return $this->render('gemtype/edit.html.twig', [
            'gemtype' => $gemtype,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gemtype_delete', methods: ['POST'])]
    public function delete(Request $request, Gemtype $gemtype, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gemtype->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($gemtype);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gemtype_index', [], Response::HTTP_SEE_OTHER);
    }
}