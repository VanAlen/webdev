<?php

namespace App\Controller;

use App\Repository\GemRepository;
use App\Repository\JewelriesRepository;
use App\Repository\GembundlesRepository;
use App\Repository\CustomjewelriesRepository;
use App\Repository\UserRepository;
use App\Repository\ActivitylogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_index')]
    public function index(
        GemRepository $gemRepo,
        JewelriesRepository $jewelryRepo,
        GembundlesRepository $bundleRepo,
        CustomjewelriesRepository $customRepo,
        UserRepository $userRepo,
        ActivitylogRepository $logRepo
    ): Response {
        $gemCount = $gemRepo->count([]);
        $jewelryCount = $jewelryRepo->count([]);
        $bundleCount = $bundleRepo->count([]);
        $customCount = $customRepo->count([]);
        $userCount = $userRepo->count([]);

        $staffCount = $userRepo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_STAFF%')
            ->getQuery()
            ->getSingleScalarResult();

        $totalRecords = $gemCount + $jewelryCount + $bundleCount + $customCount;
        $activityCount = $logRepo->count([]);

        return $this->render('admin.html.twig', [
            'userCount' => $userCount,
            'staffCount' => $staffCount,
            'totalRecords' => $totalRecords,
            'activityCount' => $activityCount,
            'gemCount' => $gemCount,
            'jewelryCount' => $jewelryCount,
            'bundleCount' => $bundleCount,
            'customCount' => $customCount,
        ]);
    }
}