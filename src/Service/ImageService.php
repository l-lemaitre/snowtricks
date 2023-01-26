<?php

namespace App\Service;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageService
{
    public function addTrickImage($entityManager, $slugger, $trick, $imgs, $imgDirectory)
    {
        foreach ($imgs as $img) {
            $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $img->guessExtension();

            // Move the file to the directory where images are stored
            try {
                $img->move(
                    $imgDirectory,
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle exception if something happens during file upload
                return 'Error upload.';
            }

            $image = new Image();
            $image->setTrick($trick);
            $image->setUrl("/img/" . $newFilename);

            $entityManager->persist($image);

            $trick->setImage($image);
            $trick->addImage($image);
        }
    }

    public function addProfilePicture($slugger, $user, $img, $imgDirectory)
    {
        $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $img->guessExtension();

        // Move the file to the directory where images are stored
        try {
            $img->move(
                $imgDirectory,
                $newFilename
            );
        } catch (FileException $e) {
            // Handle exception if something happens during file upload
            return 'Error upload.';
        }

        $user->setProfilePicture("/img/" . $newFilename);
    }
}
