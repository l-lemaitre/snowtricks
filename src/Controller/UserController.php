<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/create-user', name: 'create_user')]
    public function createUser(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $entityManager = $doctrine->getManager();

        $userRepository = new UserRepository($doctrine);

        $user = new User();
        $user->setUsername('Nerofaust');
        $user->setEmail('ludoviclemaitre@orange.fr');
        $user->setPassword('Test');
        $user->setLastname('Lemaître');
        $user->setFirstname('Ludovic');
        $user->setDeleted(0);
        $user->setRegistrationDate($userRepository->CurrentDate);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        // tell Doctrine you want to (eventually) save the User (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(int $id, UserRepository $userRepository, ManagerRegistry $doctrine): Response
    {
        $user = $userRepository->find($id);

        $repository = $doctrine->getRepository(User::class);

        // look for a single User by its primary key (usually "id")
        $user = $repository->find($id);

        // look for *all* User objects
        $users = $repository->findAll();

        //return new Response('Check out this great user : '.$user->getUsername());

        echo "<pre>";
        var_dump($users);
        exit;
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setUsername('Nerofaust');

        // Deleting an Object
        //$entityManager->remove($user);

        $entityManager->flush();

        return $this->redirectToRoute('user_show', [
            'id' => $user->getId()
        ]);
    }
}
