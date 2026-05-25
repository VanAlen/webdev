<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

abstract class BaseApiController extends AbstractController
{
    protected function jsonResponse($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        return $this->json($data, $status, $headers, $context);
    }

    protected function getAuthenticatedUser()
    {
        return $this->getUser();
    }
}