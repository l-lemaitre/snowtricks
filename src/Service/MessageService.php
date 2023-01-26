<?php

namespace App\Service;

use App\Entity\Message;

class MessageService
{
    public function addMessage($entityManager, $trick, $user, $contents, $currentDate)
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
