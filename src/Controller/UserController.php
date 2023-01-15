<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\RemoveUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /* Demo
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }*/

    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher, SluggerInterface $slugger, UserRepository $userRepository, int $id): Response
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
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $img->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $img->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                    return 'Error upload.';
                }

                $user->setProfilePicture("/img/" . $newFilename);
            }

            $password = $form->get('password')->getData();

            if (trim($password)) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $password
                    )
                );
            } else {
                $user->setPassword($user->getPassword());
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $type = 'success';
            $message = 'Modification du profil réussi.';

            $this->addFlash($type, $message);

            return $this->redirectToRoute('app_home_page');
        }

        if ($removeForm->isSubmitted() && $removeForm->isValid()) {
            $user->setDeleted(1);
            $user->setUnsubscribeDate($userRepository->CurrentDate);

            $entityManager->persist($user);
            $entityManager->flush();

            $type = 'success';
            $message = 'Suppression du compte réussi.';

            $this->addFlash($type, $message);

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
