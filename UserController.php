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
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if (!empty($plainPassword)) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }
            
            $em->persist($user);
            $em->flush();

            // Log the creation action
            $this->activityLogger->log('USER_CREATE', sprintf(
                'User created: %s (ID: %d) by %s',
                $user->getUsername(),
                $user->getId(),
                $this->getCurrentUsername()
            ));

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

        // Store original data for comparison
        $originalData = [
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'status' => $user->getStatus(),
        ];

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $passwordChanged = false;
            
            if (!empty($plainPassword)) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
                $passwordChanged = true;
            }
            
            $em->flush();

            // Log the update action with details
            $changes = $this->getChanges($originalData, $user, $passwordChanged);
            
            $this->activityLogger->log('USER_UPDATE', sprintf(
                'User updated: %s (ID: %d)%s by %s',
                $user->getUsername(),
                $user->getId(),
                $changes ? ' - Changes: ' . $changes : '',
                $this->getCurrentUsername()
            ));

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

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            // Log the deletion BEFORE removing the user
            $this->activityLogger->log('USER_DELETE', sprintf(
                'User deleted: %s (ID: %d, Roles: %s) by %s',
                $user->getUsername(),
                $user->getId(),
                implode(', ', $user->getRoles()),
                $this->getCurrentUsername()
            ));
            
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'User deleted successfully.');
        }

        return $this->redirectToRoute('app_user_index');
    }

    #[Route('/{id}/force-status', name: 'app_user_force_status', methods: ['GET'])]
    public function forceStatus(?User $user, EntityManagerInterface $em): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        
        $oldStatus = $user->getStatus();
        $user->setStatus('disabled');
        $em->flush();

        // Log the status change
        $this->activityLogger->log('USER_STATUS_CHANGE', sprintf(
            'User status changed from %s to disabled for user: %s (ID: %d) by %s',
            $oldStatus,
            $user->getUsername(),
            $user->getId(),
            $this->getCurrentUsername()
        ));
        
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

            // Log the test update
            $this->activityLogger->log('USER_TEST_UPDATE', sprintf(
                'Test update: User %s (ID: 2) status changed from %s to active by %s',
                $user->getUsername(),
                $oldStatus,
                $this->getCurrentUsername()
            ));

            return new Response('Updated user 2 status to active');
        }
        
        return new Response('User not found');
    }

    /**
     * Helper method to get current username
     */
    private function getCurrentUsername(): string
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            return $user->getUsername();
        }
        
        return 'anonymous';
    }

    /**
     * Helper method to detect changes during update
     */
    private function getChanges(array $originalData, User $updatedUser, bool $passwordChanged): string
    {
        $changes = [];

        // Check username change
        if ($originalData['username'] !== $updatedUser->getUsername()) {
            $changes[] = sprintf('username: %s → %s', $originalData['username'], $updatedUser->getUsername());
        }

        // Check roles change
        $newRoles = $updatedUser->getRoles();
        if ($originalData['roles'] !== $newRoles) {
            $changes[] = sprintf('roles: %s → %s', 
                implode(', ', $originalData['roles']), 
                implode(', ', $newRoles)
            );
        }

        // Check status change
        if ($originalData['status'] !== $updatedUser->getStatus()) {
            $changes[] = sprintf('status: %s → %s', $originalData['status'], $updatedUser->getStatus());
        }

        // Check password change
        if ($passwordChanged) {
            $changes[] = 'password: changed';
        }

        return implode(', ', $changes);
    }
}
