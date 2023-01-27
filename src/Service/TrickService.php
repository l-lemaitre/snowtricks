<?php

namespace App\Service;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class TrickService
{
    public function addTrick(ObjectManager $entityManager, Trick $trick, User $user, string $slug, \datetime $currentDate): void
    {
        $trick->setUser($user);

        $slug = strtolower($slug);
        $slug = rawurlencode($slug);
        $trick->setSlug($slug);

        $trick->setDeleted(0);

        $trick->setDateAdd($currentDate);
        $trick->setDateUpdated($currentDate);

        $entityManager->persist($trick);
    }

    public function editTrick(ObjectManager $entityManager, Trick $trick, User $user, string $slug, \Datetime $currentDate): void
    {
        $trick->setUser($user);

        $slug = strtolower($slug);
        $slug = rawurlencode($slug);
        $trick->setSlug($slug);

        $trick->setDateUpdated($currentDate);

        $entityManager->persist($trick);
        $entityManager->flush();
    }

    public function removeTrick(ObjectManager $entityManager, Trick $trick, \Datetime $currentDate): void
    {
        $trick->setDeleted(1);
        $trick->setDateUpdated($currentDate);

        $entityManager->persist($trick);
        $entityManager->flush();
    }
}
