<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private string $timezone;

    private UserPasswordHasherInterface $userPasswordHasher;

    public const USERS = [
        [
            'username' => 'Admin',
            'email' => 'contact@llemaitre.com',
            'password' => 'admin_55'
        ]
    ];

    public const USERS_REFERENCE = 'users';

    public function __construct(string $timezone, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->timezone = $timezone;

        date_default_timezone_set($this->timezone);
        $this->currentDate = new \DateTime();

        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $user) {
            $userEntity = new User();
            $userEntity->setUsername($user['username']);
            $userEntity->setEmail($user['email']);
            $userEntity->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $userEntity,
                    $user['password']
                )
            );
            $userEntity->setRegistrationDate($this->currentDate);
            $userEntity->setIsVerified(1);
            $userEntity->setRoles(["ROLE_USER"]);
            $manager->persist($userEntity);
        }

        $manager->flush();

        $this->addReference(self::USERS_REFERENCE, $userEntity);
    }
}
