<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TrickController extends AbstractController
{
    #[Route('/trick', name: 'app_trick')]
    public function index(): Response
    {
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
        ]);
    }

    #[Route('/create-trick', name: 'create_trick')]
    public function createUser(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $category = $doctrine->getRepository(Category::class)->find(1);
        $user = $doctrine->getRepository(User::class)->find(1);
        $image = $doctrine->getRepository(Image::class)->find(1);

        $trickRepository = new TrickRepository($doctrine);

        $trick = new Trick();
        $trick->setCategory($category);
        $trick->setUser($user);
        $trick->setImage($image);
        $trick->setTitle('mute');
        $trick->setContents('Test.');
        $trick->setSlug('mute');
        $trick->setPublished(1);
        $trick->setDeleted(0);
        $trick->setDateAdd($trickRepository->CurrentDate);
        $trick->setDateUpdated($trickRepository->CurrentDate);

        $errors = $validator->validate($trick);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($trick);
        $entityManager->flush();

        return new Response('Saved new trick with id '.$trick->getId());
    }
}
