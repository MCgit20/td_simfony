<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher) {
        
    }
    
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']); 
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'azerty'));
        $manager->persist($admin);
        
        // Ajouter une référence pour l'admin
        $this->addReference('admin', $admin);

        for ($i=0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'azerty')); 
            $manager->persist($user);
            
            // Ajouter une référence pour chaque user
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }

    public static function getGroups(): array { return ['user']; }
}
