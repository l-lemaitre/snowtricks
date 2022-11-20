<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Repository\ImageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/create-image', name: 'app_create_image')]
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

    #[Route('/image/delete/{id}', name: 'app_image_delete', methods: ['delete'])]
    public function delete(int $id, ImageRepository $imageRepository): Response
    {
        $image = $imageRepository->find($id);

        $imageRepository->remove($image, true);

        $filesystem = new Filesystem();
        $imagePath = $image->getUrl();
        $publicDirectoryPath = $this->getParameter('public_directory');

        if($filesystem->exists($publicDirectoryPath.$imagePath)){
            $filesystem->remove($publicDirectoryPath.$imagePath); //same as unlink($imagePath) in php
        }

        return new JsonResponse(true);
    }
}
