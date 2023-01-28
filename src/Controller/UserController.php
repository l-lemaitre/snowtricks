<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Form\RemoveUserType;
use App\Repository\UserRepository;
use App\Service\ImageService;
use App\Service\UserService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher, SluggerInterface $slugger, UserRepository $userRepository, UserService $userService, ImageService $imageService, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userVerified = $user->isIsVerified();

        $form = $this->createForm(EditUserType::class, $user);
        $removeForm = $this->createForm(RemoveUserType::class, $user);

        $form->handleRequest($request);
        $removeForm->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('profile_picture')->getData();

            if ($img) {
                $imageService->addProfilePicture($slugger, $user, $img, $this->getParameter('img_directory'));
            }

            $password = $form->get('password')->getData();

            $userService->editUser($entityManager, $user, $userPasswordHasher, $password);

            $type = 'success';
            $message = 'Modification du profil réussi.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        if ($removeForm->isSubmitted() && $removeForm->isValid()) {
            $userService->removeUser($entityManager, $user, $userRepository->currentDate);

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('form/edit-user.html.twig', [
            'userVerified' => $userVerified,
            'user' => $user,
            'form' => $form->createView(),
            'removeForm' => $removeForm->createView()
        ]);
    }
}
