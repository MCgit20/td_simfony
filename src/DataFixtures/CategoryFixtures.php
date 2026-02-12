<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public const CATEGORIES = [
        'Technologie',
        'Voyage',
        'Cuisine',
        'Sport',
        'Culture'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $index => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setContent("Contenu de la catégorie $categoryName");
            
            $manager->persist($category);
            
            // Créer la référence AVANT le flush
            $this->addReference('category_' . $index, $category);
        }

        $manager->flush();
    }
    public static function getGroups(): array { return ['category']; }
}