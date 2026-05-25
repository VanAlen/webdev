<?php
// src/Repository/ActivitylogRepository.php
namespace App\Repository;

use App\Entity\Activitylog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activitylog>
 */
class ActivitylogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activitylog::class);
    }

    /**
     * Find activity logs with filters
     */
    public function findByFilters(
        ?string $action = null,
        ?int $userId = null,
        ?string $username = null,
        ?string $role = null,
        ?\DateTimeInterface $startDate = null,
        ?\DateTimeInterface $endDate = null,
        ?string $search = null,
        string $orderBy = 'dateTime',
        string $orderDir = 'DESC',
        int $limit = 50,
        int $offset = 0
    ): array {
        $qb = $this->createQueryBuilder('l');

        // Action filter
       if ($action) {
            if ($action === 'CREATE') {
                $qb->andWhere('l.action LIKE :action')
                ->setParameter('action', '%CREATE%');
            } elseif ($action === 'UPDATE') {
                $qb->andWhere('l.action LIKE :action')
                ->setParameter('action', '%UPDATE%');
            } elseif ($action === 'DELETE') {
                $qb->andWhere('l.action LIKE :action')
                ->setParameter('action', '%DELETE%');
            } else {
                $qb->andWhere('l.action = :action')
                ->setParameter('action', $action);
            }
        }

        // User ID filter
        if ($userId) {
            $qb->andWhere('l.user = :userId')
               ->setParameter('userId', $userId);
        }

        // Username filter
        if ($username) {
            $qb->andWhere('l.username LIKE :username')
               ->setParameter('username', '%' . $username . '%');
        }

        // Role filter
        if ($role) {
            $qb->andWhere('l.userRole = :role')
               ->setParameter('role', $role);
        }

        // Date range filter
        if ($startDate) {
            $qb->andWhere('l.dateTime >= :startDate')
               ->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $qb->andWhere('l.dateTime <= :endDate')
               ->setParameter('endDate', $endDate);
        }

        // Search in targetData
        if ($search) {
            $qb->andWhere('l.targetData LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        // Ordering
        $qb->orderBy('l.' . $orderBy, $orderDir);

        // Pagination
        $qb->setMaxResults($limit)
           ->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * Count activity logs with filters (for pagination)
     */
    public function countByFilters(
        ?string $action = null,
        ?int $userId = null,
        ?string $username = null,
        ?string $role = null,
        ?\DateTimeInterface $startDate = null,
        ?\DateTimeInterface $endDate = null,
        ?string $search = null
    ): int {
        $qb = $this->createQueryBuilder('l')
            ->select('COUNT(l.id)');

        // Action filter
        if ($action) {
            if ($action === 'ALL_CREATE') {
                $qb->andWhere('l.action LIKE :action')
                   ->setParameter('action', '%CREATE%');
            } elseif ($action === 'ALL_UPDATE') {
                $qb->andWhere('l.action LIKE :action')
                   ->setParameter('action', '%UPDATE%');
            } elseif ($action === 'ALL_DELETE') {
                $qb->andWhere('l.action LIKE :action')
                   ->setParameter('action', '%DELETE%');
            } else {
                $qb->andWhere('l.action = :action')
                   ->setParameter('action', $action);
            }
        }

        // User ID filter
        if ($userId) {
            $qb->andWhere('l.user = :userId')
               ->setParameter('userId', $userId);
        }

        // Username filter
        if ($username) {
            $qb->andWhere('l.username LIKE :username')
               ->setParameter('username', '%' . $username . '%');
        }

        // Role filter
        if ($role) {
            $qb->andWhere('l.userRole = :role')
               ->setParameter('role', $role);
        }

        // Date range filter
        if ($startDate) {
            $qb->andWhere('l.dateTime >= :startDate')
               ->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $qb->andWhere('l.dateTime <= :endDate')
               ->setParameter('endDate', $endDate);
        }

        // Search in targetData
        if ($search) {
            $qb->andWhere('l.targetData LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Get distinct actions for dropdown
     */
    public function getDistinctActions(): array
    {
        $actions = $this->createQueryBuilder('l')
            ->select('DISTINCT l.action')
            ->orderBy('l.action', 'ASC')
            ->getQuery()
            ->getResult();

        return array_column($actions, 'action');
    }

    /**
     * Get distinct roles for dropdown
     */
    public function getDistinctRoles(): array
    {
        $roles = $this->createQueryBuilder('l')
            ->select('DISTINCT l.userRole')
            ->orderBy('l.userRole', 'ASC')
            ->getQuery()
            ->getResult();

        return array_column($roles, 'userRole');
    }

    /**
     * Get distinct usernames for dropdown
     */
    public function getDistinctUsernames(): array
    {
        $usernames = $this->createQueryBuilder('l')
            ->select('DISTINCT l.username')
            ->orderBy('l.username', 'ASC')
            ->getQuery()
            ->getResult();

        return array_column($usernames, 'username');
    }
}