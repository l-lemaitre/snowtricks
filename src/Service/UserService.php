<?php

namespace App\Service;

class UserService
{
    public function editUser($entityManager, $user, $password, $userPasswordHasher)
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

    public function removeUser($entityManager, $user, $currentDate)
    {
        $user->setDeleted(1);
        $user->setUnsubscribeDate($currentDate);

        $entityManager->persist($user);
        $entityManager->flush();
    }
}
