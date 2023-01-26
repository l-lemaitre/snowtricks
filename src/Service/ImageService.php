<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageService
{
    public function addTrickImage(ObjectManager $entityManager, SluggerInterface $slugger, Trick $trick, array $imgs,string $imgDirectory): bool
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

        return true;
    }

    public function addProfilePicture(SluggerInterface $slugger, User $user, UploadedFile $img, string $imgDirectory): bool
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

        return true;
    }
}
