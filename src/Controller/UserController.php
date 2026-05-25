<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\ActivityLogger;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private ActivityLogger $activityLogger
    ) {
    }

    #[Route('', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Admin can see all users, Staff can only see users (not admins)
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $users = $userRepository->findAll();
        
        // If Staff, filter out admin users
        if (!$this->isGranted('ROLE_ADMIN')) {
            $users = array_filter($users, fn($u) => !in_array('ROLE_ADMIN', $u->getRoles()));
        }
        
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Only Admin and Staff can create users
        $this->denyAccessUnlessGranted('ROLE_STAFF');
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if (!empty($plainPassword)) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }
            
            // Role restrictions based on current user
            $selectedRoles = $user->getRoles();
            
            if ($this->isGranted('ROLE_ADMIN')) {
                // Admin can create Admin or Staff
                // No restriction - can assign any role
            } elseif ($this->isGranted('ROLE_STAFF')) {
                // Staff can ONLY create Staff (not Admin)
                if (in_array('ROLE_ADMIN', $selectedRoles)) {
                    $this->addFlash('error', 'You cannot create Admin accounts.');
                    return $this->redirectToRoute('app_user_new');
                }
                // Force role to STAFF only
                $user->setRoles(['ROLE_STAFF']);
            }
            
            $em->persist($user);
            $em->flush();

            $this->activityLogger->log(
                'CREATE',
                sprintf('User: %s (ID: %d)', $user->getUsername(), $user->getId())
            );

            $this->addFlash('success', 'User created successfully!');
            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(?User $user): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        
        // Check if user can view this profile
        $this->checkUserAccess($user);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?User $user, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        
        // Check if user can edit this profile
        $this->checkUserAccess($user);

        $originalData = [
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'status' => $user->getStatus(),
        ];

        // AFTER
        $currentRole = $user->getRoles()[0] ?? 'ROLE_USER';
        $form = $this->createForm(UserType::class, $user);
        $form->get('roles')->setData($currentRole);  // pre-fill dropdown
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $passwordChanged = false;
            
            if (!empty($plainPassword)) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
                $passwordChanged = true;
            }
            
            // AFTER
            if ($this->isGranted('ROLE_ADMIN')) {
                // Admin can change roles — read the single dropdown value and wrap it in array
                $selectedRole = $form->get('roles')->getData();
                $user->setRoles([$selectedRole]);
            } else {
                // Staff cannot change roles or status — restore originals
                $user->setRoles($originalData['roles']);
                $user->setStatus($originalData['status']);
            }
            
            $em->flush();

            $changes = $this->getChanges($originalData, $user, $passwordChanged);
            
            $this->activityLogger->log(
                'UPDATE',
                sprintf('User: %s (ID: %d) - Changes: %s', $user->getUsername(), $user->getId(), $changes ?: 'none')
            );

            $this->addFlash('success', 'User updated successfully!');
            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
    
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, ?User $user, EntityManagerInterface $em): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        
        // Only Admin can delete users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        /** @var \App\Entity\User $currentUser */
        $currentUser = $this->getUser();
        
        // Cannot delete self
        if ($user->getId() === $currentUser->getId()) {
            $this->addFlash('error', 'You cannot delete your own account.');
            return $this->redirectToRoute('app_user_index');
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $this->activityLogger->log(
                'DELETE',
                sprintf('User: %s (ID: %d, Roles: %s)', $user->getUsername(), $user->getId(), implode(', ', $user->getRoles()))
            );
            
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'User deleted successfully.');
            return $this->redirectToRoute('app_user_index');
        }
        
        // Add return for when CSRF token is invalid
        $this->addFlash('error', 'Invalid CSRF token.');
        return $this->redirectToRoute('app_user_index');
    }
    #[Route('/{id}/force-status', name: 'app_user_force_status', methods: ['GET'])]
    public function forceStatus(?User $user, EntityManagerInterface $em): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        
        // Only Admin can force status change
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $oldStatus = $user->getStatus();
        $user->setStatus('disabled');
        $em->flush();

        $this->activityLogger->log(
            'STATUS_CHANGE',
            sprintf('User: %s (ID: %d) - Status: %s → disabled', $user->getUsername(), $user->getId(), $oldStatus)
        );
        
        return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
    }

    #[Route('/test-update', name: 'test_update', methods: ['GET'])]
    public function testUpdate(EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find(2);
        if ($user) {
            $oldStatus = $user->getStatus();
            $user->setStatus('active');
            $em->flush();

            $this->activityLogger->log(
                'TEST_UPDATE',
                sprintf('User: %s (ID: 2) - Status: %s → active', $user->getUsername(), $oldStatus)
            );

            return new Response('Updated user 2 status to active');
        }
        
        return new Response('User not found');
    }
    private function checkUserAccess(User $targetUser): void
    {
        /** @var \App\Entity\User $currentUser */
        $currentUser = $this->getUser();
        
        // Admin can access everything
        if ($this->isGranted('ROLE_ADMIN')) {
            return;
        }
        
        // Staff can only access non-admin users
        if ($this->isGranted('ROLE_STAFF')) {
            if (in_array('ROLE_ADMIN', $targetUser->getRoles())) {
                throw $this->createAccessDeniedException('You cannot access admin users.');
            }
            return;
        }
        
        // Regular users can only access their own profile
        if ($targetUser->getId() !== $currentUser->getId()) {
            throw $this->createAccessDeniedException('You can only access your own profile.');
        }
    }

    private function getChanges(array $originalData, User $updatedUser, bool $passwordChanged): string
    {
        $changes = [];

        if ($originalData['username'] !== $updatedUser->getUsername()) {
            $changes[] = sprintf('username: %s → %s', $originalData['username'], $updatedUser->getUsername());
        }

        if ($originalData['roles'] !== $updatedUser->getRoles()) {
            $changes[] = sprintf('roles: %s → %s', 
                implode(', ', $originalData['roles']), 
                implode(', ', $updatedUser->getRoles())
            );
        }

        if ($originalData['status'] !== $updatedUser->getStatus()) {
            $changes[] = sprintf('status: %s → %s', $originalData['status'], $updatedUser->getStatus());
        }

        if ($passwordChanged) {
            $changes[] = 'password: changed';
        }

        return implode(', ', $changes);
    }
}