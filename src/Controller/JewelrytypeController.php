<?php
// src/Controller/JewelrytypeController.php

namespace App\Controller;

use App\Entity\Jewelries;  // Add this import (your Jewelry entity)
use App\Entity\Jewelrytype;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/jewelrytype')]
#[IsGranted('ROLE_ADMIN')]
class JewelrytypeController extends AbstractController
{
    #[Route('/', name: 'app_jewelrytype_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $jewelrytypes = $em->getRepository(Jewelrytype::class)->findAll();
        return $this->render('jewelrytype/index.html.twig', [
            'jewelrytypes' => $jewelrytypes,
        ]);
    }

    #[Route('/new', name: 'app_jewelrytype_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            if ($name) {
                $jewelrytype = new Jewelrytype();
                $jewelrytype->setName($name);
                $em->persist($jewelrytype);
                $em->flush();
                $this->addFlash('success', 'Jewelry type added!');
                return $this->redirectToRoute('app_jewelries_new');
            }
        }
        
        return $this->render('jewelrytype/new.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_jewelrytype_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jewelrytype $jewelrytype, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            if ($name) {
                $jewelrytype->setName($name);
                $em->flush();
                $this->addFlash('success', 'Jewelry type updated!');
                return $this->redirectToRoute('app_jewelries_new');
            }
        }
        
        return $this->render('jewelrytype/edit.html.twig', [
            'jewelrytype' => $jewelrytype,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_jewelrytype_delete', methods: ['POST'])]
    public function delete(Request $request, Jewelrytype $jewelrytype, EntityManagerInterface $em): Response
    {
        // Use App\Entity\Jewelries instead of Jewelry
        $jewelryCount = $em->getRepository(Jewelries::class)->count(['jewelrytype' => $jewelrytype]);
        
        if ($jewelryCount > 0) {
            $this->addFlash('error', 'Cannot delete: ' . $jewelryCount . ' jewelry item(s) use this type.');
        } else {
            $em->remove($jewelrytype);
            $em->flush();
            $this->addFlash('success', 'Jewelry type deleted!');
        }
        
        return $this->redirectToRoute('app_jewelrytype_index');
    }
}