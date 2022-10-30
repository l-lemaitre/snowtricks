<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }

    #[Route('/create-image', name: 'create_image')]
    public function createImage(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $trick = $doctrine->getRepository(Trick::class)->find(1);

        $image = new Image();
        $image->setTrick($trick);
        $image->setUrl('/img/Picswiss_VD-44-23.jpeg');

        $errors = $validator->validate($image);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($image);
        $entityManager->flush();

        return new Response('Saved new image with id '.$image->getId());
    }
}
