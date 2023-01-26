<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    private string $timezone;

    public const TRICKS = [
        [
            'title' => 'mute',
            'contents' => 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.'
        ],
        [
            'title' => 'sad',
            'contents' => 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.'
        ],
        [
            'title' => 'indy',
            'contents' => 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.'
        ],
        [
            'title' => 'stalefish',
            'contents' => 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.'
        ],
        [
            'title' => 'tail grab',
            'contents' => 'Saisie de la partie arrière de la planche, avec la main arrière.'
        ],
        [
            'title' => 'nose grab',
            'contents' => 'Saisie de la partie avant de la planche, avec la main avant.'
        ],
        [
            'title' => 'japan',
            'contents' => 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.'
        ],
        [
            'title' => 'seat belt',
            'contents' => 'Saisie du carre frontside à l\'arrière avec la main avant.'
        ],
        [
            'title' => 'truck driver',
            'contents' => 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).'
        ],
        [
            'title' => '180',
            'contents' => 'Un 180 désigne un demi-tour, soit 180 degrés d\'angle.'
        ]
    ];

    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;

        date_default_timezone_set($this->timezone);
        $this->currentDate = new \DateTime();
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::TRICKS as $trick) {
            $slug = $trick['title'];
            $slug = strtolower($slug);
            $slug = rawurlencode($slug);

            $categoryGrabs = $this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE);
            $categoryRotations = $this->getReference(CategoryFixtures::CATEGORY_ROTATIONS_REFERENCE);
            $userFixtures = $this->getReference(UserFixtures::USERS_REFERENCE);

            $trickEntity = new Trick();
            if ($trick['title'] == '180') {
                $trickEntity->setCategory($categoryRotations);
            } else {
                $trickEntity->setCategory($categoryGrabs);
            }
            $trickEntity->setUser($userFixtures);
            $trickEntity->setTitle($trick['title']);
            $trickEntity->setContents($trick['contents']);
            $trickEntity->setSlug($slug);
            $trickEntity->setPublished(1);
            $trickEntity->setDateAdd($this->currentDate);
            $trickEntity->setDateUpdated($this->currentDate);
            $manager->persist($trickEntity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}
