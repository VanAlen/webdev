<?php
// src/Controller/ActivitylogController.php
namespace App\Controller;

use App\Repository\ActivitylogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('activitylog')]
class ActivitylogController extends AbstractController
{
    #[Route('', name: 'app_activity_log_index', methods: ['GET'])]
    public function index(Request $request, ActivitylogRepository $activitylogRepository): Response
    {
        // Get filters from request
        $action = $request->query->get('action');
        $userId = $request->query->get('user_id');
        $username = $request->query->get('username');
        $role = $request->query->get('role');
        $search = $request->query->get('search');
        
        // Date filters
        $startDate = $request->query->get('start_date') ? 
            \DateTime::createFromFormat('Y-m-d', $request->query->get('start_date')) : null;
        $endDate = $request->query->get('end_date') ? 
            \DateTime::createFromFormat('Y-m-d', $request->query->get('end_date')) : null;
        
        // Pagination
        $page = (int) $request->query->get('page', 1);
        $limit = 50;
        $offset = ($page - 1) * $limit;

        // Get logs with filters
        $logs = $activitylogRepository->findByFilters(
            $action,
            $userId,
            $username,
            $role,
            $startDate,
            $endDate,
            $search,
            'dateTime',
            'DESC',
            $limit,
            $offset
        );

        // Count total for pagination
        $total = $activitylogRepository->countByFilters(
            $action,
            $userId,
            $username,
            $role,
            $startDate,
            $endDate,
            $search
        );

        // Get distinct values for dropdowns
        $actions = $activitylogRepository->getDistinctActions();
        $roles = $activitylogRepository->getDistinctRoles();
        $usernames = $activitylogRepository->getDistinctUsernames();

        return $this->render('activitylog/index.html.twig', [
            'logs' => $logs,
            'actions' => $actions,
            'roles' => $roles,
            'usernames' => $usernames,
            'current_filters' => [
                'action' => $action,
                'user_id' => $userId,
                'username' => $username,
                'role' => $role,
                'search' => $search,
                'start_date' => $request->query->get('start_date'),
                'end_date' => $request->query->get('end_date'),
            ],
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit),
            ],
        ]);
    }
}