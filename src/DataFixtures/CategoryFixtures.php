<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private string $timezone;

    public const CATEGORIES = [
        [
            'title' => 'Grabs'
        ],
        [
            'title' => 'Rotations'
        ]
    ];

    public const CATEGORY_GRABS_REFERENCE = 'grabs';
    public const CATEGORY_ROTATIONS_REFERENCE = 'rotations';

    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;

        date_default_timezone_set($this->timezone);
        $this->currentDate = new \DateTime();
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $category) {
            $slug = $category['title'];
            $slug = strtolower($slug);
            $slug = rawurlencode($slug);

            $categoryEntity = new Category();
            $categoryEntity->setTitle($category['title']);
            $categoryEntity->setSlug($slug);
            $categoryEntity->setDateAdd($this->currentDate);
            $manager->persist($categoryEntity);

            if ($categoryEntity->GetTitle() == 'Grabs') {
                $this->addReference(self::CATEGORY_GRABS_REFERENCE, $categoryEntity);
            } else {
                $this->addReference(self::CATEGORY_ROTATIONS_REFERENCE, $categoryEntity);
            }
        }

        $manager->flush();
    }
}
