<?php

namespace App\Controller;

use App\Repository\GemRepository;
use App\Repository\JewelriesRepository;
use App\Repository\GembundlesRepository;
use App\Repository\CustomjewelriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(
        GemRepository $gemRepo,
        JewelriesRepository $jewelryRepo,
        GembundlesRepository $bundleRepo,
        CustomjewelriesRepository $customRepo
    ): Response {
        $gemCount = $gemRepo->count([]);
        $jewelryCount = $jewelryRepo->count([]);
        $bundleCount = $bundleRepo->count([]);
        $customCount = $customRepo->count([]);
        
        $totalRecords = $gemCount + $jewelryCount + $bundleCount + $customCount;
        
        // Calculate low stock count
        $lowStockCount = 0;
        $gems = $gemRepo->findAll();
        foreach ($gems as $gem) {
            if (method_exists($gem, 'getStock') && $gem->getStock() <= 5) {
                $lowStockCount++;
            }
        }
        $jewelries = $jewelryRepo->findAll();
        foreach ($jewelries as $jewelry) {
            if (method_exists($jewelry, 'getStock') && $jewelry->getStock() <= 5) {
                $lowStockCount++;
            }
        }
        $bundles = $bundleRepo->findAll();
        foreach ($bundles as $bundle) {
            if (method_exists($bundle, 'getStock') && $bundle->getStock() <= 5) {
                $lowStockCount++;
            }
        }
        
        // Stock status text
        if ($lowStockCount > 5) {
            $lowStockText = 'Critical';
        } elseif ($lowStockCount > 0) {
            $lowStockText = 'Low Stock';
        } else {
            $lowStockText = 'Healthy';
        }
        
        // Get most popular item (highest stock sold or most viewed)
        // For now, get the category with most items
        $categories = [
            ['name' => 'Gems', 'count' => $gemCount, 'icon' => 'gem.svg', 'path' => 'app_gem_index'],
            ['name' => 'Jewelries', 'count' => $jewelryCount, 'icon' => 'jewelry.svg', 'path' => 'app_jewelries_index'],
            ['name' => 'Bundles', 'count' => $bundleCount, 'icon' => 'bundle.svg', 'path' => 'app_gembundles_index'],
            ['name' => 'Custom', 'count' => $customCount, 'icon' => 'custom.svg', 'path' => 'app_customjewelries_index'],
        ];
        
        usort($categories, function($a, $b) {
            return $b['count'] <=> $a['count'];
        });
        
        $popularItem = $categories[0];

        return $this->render('product/index.html.twig', [
            'gemCount' => $gemCount,
            'jewelryCount' => $jewelryCount,
            'bundleCount' => $bundleCount,
            'customCount' => $customCount,
            'totalRecords' => $totalRecords,
            'lowStockText' => $lowStockText,
            'popularItem' => $popularItem,
        ]);
    }
}