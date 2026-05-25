<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Service\ActivityLogger;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DoctrineActivitySubscriber
{
    public function __construct(private ActivityLogger $logger) {}

    #[AsDoctrineListener(event: Events::postPersist)]
    public function onCreate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof User) {
            $this->logger->log(
                'CREATE',
                sprintf('Created user %s [id=%d]', $entity->getUsername(), $entity->getId())
            );
        }
    }

    #[AsDoctrineListener(event: Events::postUpdate)]
    public function onUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof User) {
            $this->logger->log(
                'UPDATE',
                sprintf('Updated user %s [id=%d]', $entity->getUsername(), $entity->getId())
            );
        }
    }

    #[AsDoctrineListener(event: Events::postRemove)]
    public function onDelete(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof User) {
            $this->logger->log(
                'DELETE',
                sprintf('Deleted user %s [id=%d]', $entity->getUsername(), $entity->getId())
            );
        }
    }
}
