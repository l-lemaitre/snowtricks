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
