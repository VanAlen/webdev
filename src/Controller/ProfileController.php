<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }
    
    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        
        $form = $this->createForm(ProfileFormType::class, $user, [
            'is_admin' => $this->isGranted('ROLE_ADMIN')
        ]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle profile image upload
            $imageFile = $form->get('profileImageFile')->getData();
            if ($imageFile) {
                $filename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('kernel.project_dir') . '/public/uploads/profiles', $filename);
                $user->setProfileImage('/uploads/profiles/' . $filename);
            }
            
            $entityManager->flush();
            $this->addFlash('success', 'Profile updated!');
            return $this->redirectToRoute('app_profile');
        }
        
        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
    
    #[Route('/profile/change-password', name: 'app_profile_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        
        if ($request->isMethod('POST')) {
            $oldPassword = $request->request->get('old_password');
            $newPassword = $request->request->get('new_password');
            
            if ($passwordHasher->isPasswordValid($user, $oldPassword)) {
                $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
                $entityManager->flush();
                $this->addFlash('success', 'Password changed!');
                return $this->redirectToRoute('app_profile');
            } else {
                $this->addFlash('error', 'Wrong current password');
            }
        }
        
        return $this->render('profile/change_password.html.twig');
    }
    
    #[Route('/admin/users', name: 'app_admin_users')]
    public function listUsers(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $users = $entityManager->getRepository(User::class)->findAll();
        
        return $this->render('profile/users_list.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/upload-profile-image', name: 'app_upload_profile_image', methods: ['POST'])]
    public function uploadProfileImage(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['success' => false, 'error' => 'Not logged in'], 401);
        }
        
        $file = $request->files->get('profileImage');
        if ($file) {
            $filename = uniqid() . '.' . $file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir') . '/public/uploads/profiles', $filename);
            
            $user->setProfileImage('/uploads/profiles/' . $filename);
            $entityManager->flush();
            
            return $this->json(['success' => true]);
        }
        
        return $this->json(['success' => false, 'error' => 'No file uploaded']);
    }
}