<?php
namespace App\Controller;

use App\Form\JewelrySearchType;
use App\Repository\JewelriesRepository;
use App\Repository\GemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
        #[Route('/search/gems', name: 'search_gems')]
        public function search(Request $request, JewelriesRepository $repo, GemRepository $gemRepo)
        {
            $form = $this->createForm(JewelrySearchType::class);
            $form->handleRequest($request);

            $gems = $gemRepo->findBy([], ['id' => 'DESC'], 4);
            $jewelries = [];

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $priceRange = $request->query->get('price');

                $isGemEmpty = empty($data['gemtype']);
                $isJewelryEmpty = empty($data['jewelrytype']);
                $isPriceEmpty = empty($priceRange);

                // Case 1: All filters empty
                if ($isGemEmpty && $isJewelryEmpty && $isPriceEmpty) {
                    $this->addFlash('error', 'Please select at least one filter.');
                    $jewelries = $repo->findBy([], ['id' => 'DESC'], 4);
                    return $this->render('landing/index.html.twig', [
                        'form' => $form->createView(),
                        'gems' => $gems,
                        'jewelries' => $jewelries,
                    ]);
                }

                // Case 2: Only one filter selected
                $selectedCount = (!$isGemEmpty ? 1 : 0) + (!$isJewelryEmpty ? 1 : 0) + (!$isPriceEmpty ? 1 : 0);
                if ($selectedCount === 1) {
                    $this->addFlash('error', 'Please select at least two filters for better results.');
                    $jewelries = $repo->findBy([], ['id' => 'DESC'], 4);
                    return $this->render('landing/index.html.twig', [
                        'form' => $form->createView(),
                        'gems' => $gems,
                        'jewelries' => $jewelries,
                    ]);
                }

                // Case 3: Build query with 2+ filters
                $qb = $repo->createQueryBuilder('j');

                if (!$isGemEmpty) {
                    $qb->andWhere('j.gemtype = :gemtype')
                    ->setParameter('gemtype', $data['gemtype']->getId());
                }

                if (!$isJewelryEmpty) {
                    $qb->andWhere('j.jewelrytype = :jewelrytype')
                    ->setParameter('jewelrytype', $data['jewelrytype']->getId());
                }

                if (!$isPriceEmpty) {
                    switch ($priceRange) {
                        case 'under-100':
                            $qb->andWhere('j.price < :maxPrice')
                            ->setParameter('maxPrice', 100);
                            break;
                        case '100-500':
                            $qb->andWhere('j.price BETWEEN :minPrice AND :maxPrice')
                            ->setParameter('minPrice', 100)
                            ->setParameter('maxPrice', 500);
                            break;
                        case '500-1000':
                            $qb->andWhere('j.price BETWEEN :minPrice AND :maxPrice')
                            ->setParameter('minPrice', 500)
                            ->setParameter('maxPrice', 1000);
                            break;
                        case 'above-1000':
                            $qb->andWhere('j.price > :minPrice')
                            ->setParameter('minPrice', 1000);
                            break;
                    }
                }

                $result = $qb->setMaxResults(1)->getQuery()->getOneOrNullResult();

                // Case 4: No match found
                if (!$result) {
                    $this->addFlash('error', 'No matching jewelry found.');
                    $jewelries = $repo->findBy([], ['id' => 'DESC'], 4);
                } else {
                    return $this->redirectToRoute('app_jewelries_show', ['id' => $result->getId()]);
                }
            } else {
                $jewelries = $repo->findBy([], ['id' => 'DESC'], 4);
            }

            return $this->render('landing/index.html.twig', [
                'form' => $form->createView(),
                'gems' => $gems,
                'jewelries' => $jewelries,
            ]);
        }

    }

