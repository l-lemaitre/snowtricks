<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function editUser(ObjectManager $entityManager, User $user, UserPasswordHasherInterface $userPasswordHasher, string $password = null): void
    {
        if (trim($password)) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );
        } else {
            $user->setPassword($user->getPassword());
        }

        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function removeUser(ObjectManager $entityManager, User $user, \Datetime $currentDate): void
    {
        $user->setDeleted(1);
        $user->setUnsubscribeDate($currentDate);

        $entityManager->persist($user);
        $entityManager->flush();
    }
}
