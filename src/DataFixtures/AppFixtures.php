<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de l'admin de test
        $admin = new User();
        $admin->setEmail('admin@blog.com');
        $admin->setRoles(['ROLE_ADMIN']);
        
        // On hache le mot de passe avant de l'enregistrer
        $password = $this->hasher->hashPassword($admin, 'password');
        $admin->setPassword($password);

        $manager->persist($admin);

        // création de 5 users standards
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user-$i@blog.com");
            $user->setRoles(['ROLE_USER']);

            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}