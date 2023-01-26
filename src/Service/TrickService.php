<?php

namespace App\Service;

class TrickService
{
    public function addTrick($entityManager, $trick, $user, $slug, $currentDate)
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

    public function editTrick($entityManager, $trick, $user, $slug, $currentDate)
    {
        $trick->setUser($user);

        $slug = strtolower($slug);
        $slug = rawurlencode($slug);
        $trick->setSlug($slug);

        $trick->setDateUpdated($currentDate);

        $entityManager->persist($trick);
        $entityManager->flush();
    }

    public function removeTrick($entityManager, $trick, $currentDate)
    {
        $trick->setDeleted(1);
        $trick->setDateUpdated($currentDate);

        $entityManager->persist($trick);
        $entityManager->flush();
    }
}
