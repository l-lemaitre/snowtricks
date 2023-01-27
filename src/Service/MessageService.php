<?php

namespace App\Service;

use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class MessageService
{
    public function addMessage(ObjectManager $entityManager, Trick $trick, User $user, string $contents, \datetime $currentDate): void
    {
        $message = new Message();

        $message->setUser($user);

        $message->setTrick($trick);

        $message->setContents($contents);

        $message->setDateAdd($currentDate);
        $message->setDateUpdated($currentDate);

        $entityManager->persist($message);
        $entityManager->flush();
    }
}
