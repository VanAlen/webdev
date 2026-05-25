<?php

namespace App\Service;

use App\Entity\Activitylog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ActivityLogger
{
    private EntityManagerInterface $em;
    private TokenStorageInterface $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function log(string $action, string $targetData): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token?->getUser();

        $log = new Activitylog();
        
        if ($user && $user instanceof \App\Entity\User) {
            $log->setUser($user);
        } else {
            $log->setUsername('system');
            $log->setUserRole('ROLE_SYSTEM');
        }
        
        $log->setAction($action);
        $log->setTargetData($targetData);

        $this->em->persist($log);
        $this->em->flush();
    }
}