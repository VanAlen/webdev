<?php

namespace App\Controller\Api;

use App\Entity\Gem;
use App\Repository\GemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/gems')]
class GemController extends BaseApiController
{
    public function __construct(
        private GemRepository $gemRepository,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('', name: 'api_gems_list', methods: ['GET'])]
    public function list(): Response
    {
        // Check if user is authenticated
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $gems = $this->gemRepository->findAll();
        
        return $this->json($gems, Response::HTTP_OK, [], [
            'groups' => ['gem:read']
        ]);
    }

    #[Route('/{id}', name: 'api_gems_show', methods: ['GET'])]
    public function show(Gem $gem): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->json($gem, Response::HTTP_OK, [], [
            'groups' => ['gem:read']
        ]);
    }

    #[Route('', name: 'api_gems_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $jsonData = $request->getContent();
        
        $gem = $this->serializer->deserialize($jsonData, Gem::class, 'json');
        
        $errors = $this->validator->validate($gem);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }
        
        $this->entityManager->persist($gem);
        $this->entityManager->flush();
        
        return $this->json($gem, Response::HTTP_CREATED, [], [
            'groups' => ['gem:read']
        ]);
    }

    #[Route('/{id}', name: 'api_gems_update', methods: ['PUT'])]
    public function update(Request $request, Gem $gem): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $jsonData = $request->getContent();
        
        $this->serializer->deserialize($jsonData, Gem::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $gem
        ]);
        
        $errors = $this->validator->validate($gem);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }
        
        $this->entityManager->flush();
        
        return $this->json($gem, Response::HTTP_OK, [], [
            'groups' => ['gem:read']
        ]);
    }

    #[Route('/{id}', name: 'api_gems_delete', methods: ['DELETE'])]
    public function delete(Gem $gem): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $this->entityManager->remove($gem);
        $this->entityManager->flush();
        
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}