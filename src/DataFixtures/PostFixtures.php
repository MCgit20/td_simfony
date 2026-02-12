<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private const POST_TITLES = [
        'Les dernières tendances en IA',
        'Voyage au Japon : Guide complet',
        'Recette de tarte aux pommes',
        'Les meilleurs exercices de musculation',
        'Histoire du cinéma français',
        'Développement web moderne',
        'Randonnée en montagne',
        'Cuisine méditerranéenne',
        'Le yoga pour débutants',
        'Art contemporain',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::POST_TITLES as $index => $title) {
            $post = new Post();
            $post->setTitle($title);
            $post->setContent("Contenu détaillé de l'article : $title. Lorem ipsum dolor sit amet, consectetur adipiscing elit.");
            $post->setSlug(strtolower(str_replace(' ', '-', $title)));
            
            // Associer une catégorie - AJOUT du 2ème argument
            $categoryIndex = $index % count(CategoryFixtures::CATEGORIES);
            $category = $this->getReference('category_' . $categoryIndex, Category::class);
            $post->setCategory($category);
            
            // Assigner un auteur - AJOUT du 2ème argument
            if ($index === 0) {
                $user = $this->getReference('admin', User::class);
                $post->setUser($user);
            } else {
                $userIndex = ($index - 1) % 5;
                $user = $this->getReference('user_' . $userIndex, User::class);
                $post->setUser($user);
            }
            
            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }

    public static function getGroups(): array { return ['post']; }
}