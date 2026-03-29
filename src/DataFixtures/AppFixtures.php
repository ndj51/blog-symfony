<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Badge;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Comment;
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
        // --- 1. LES BADGES (Noms rigolos) ---
        $badgesData = [
            ['Grand Manitou', '#e74c3c', 'fa-crown'],
            ['Chasseur de Bugs', '#2ecc71', 'fa-bug'],
            ['Codeur de l\'Ombre', '#2c3e50', 'fa-user-shield'],
            ['Pipelette du Blog', '#3498db', 'fa-comments'],
            ['Sorcier PHP', '#9b59b6', 'fa-flask'],
            ['Machine à Café', '#e67e22', 'fa-mug-hot'],
            ['Archéologue du Web', '#95a5a6', 'fa-ghost'],
            ['Propulseur de JS', '#f1c40f', 'fa-rocket']
        ];

        $badgesEntities = [];
        foreach ($badgesData as $data) {
            $badge = new Badge();
            $badge->setLabel($data[0]);
            $badge->setColor($data[1]);
            $badge->setIcon($data[2]);
            $manager->persist($badge);
            $badgesEntities[] = $badge;
        }

        // --- 2. LES UTILISATEURS ---
        $users = [];
        
        // Admin
        $admin = new User();
        $admin->setEmail('admin@blog.com');
        $admin->setNickName('Le_Boss');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'password'));
        $admin->addBadge($badgesEntities[0]); // Il est d'office Grand Manitou
        $manager->persist($admin);
        $users[] = $admin;

        // Users standards
        for ($i = 1; $i <= 8; $i++) {
            $user = new User();
            $user->setEmail("user-$i@blog.com");
            $user->setNickName("Maker_$i");
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            
            // Attribution de 1 à 2 badges aléatoires
            $randomKeys = (array) array_rand($badgesEntities, rand(1, 2));
            foreach ($randomKeys as $key) {
                $user->addBadge($badgesEntities[$key]);
            }

            $manager->persist($user);
            $users[] = $user;
        }

        // --- 3. LES CATÉGORIES & ARTICLES ---
        $categories = [];
        foreach (['Tech', 'Design', 'Actualité', 'Humour'] as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        $posts = [];
        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
            $post->setTitle("Mon super article n°$i");
            $post->setContent("Contenu détaillé de l'article $i. On y parle de Symfony, de badges et de café.");
            $post->setSummary("Résumé court de l'article $i.");
            $post->setCreatedAt(new \DateTimeImmutable("-" . rand(1, 30) . " days"));
            $post->setCategory($categories[array_rand($categories)]);
            $manager->persist($post);
            $posts[] = $post;
        }

        // --- 4. LES COMMENTAIRES (Préparation) ---
        $commentTexts = [
            "Super article ! Merci pour le partage.",
            "Je ne suis pas tout à fait d'accord sur le point 3...",
            "First !",
            "Incroyable, j'ai appris plein de trucs.",
            "Est-ce qu'on peut avoir une suite sur les fixtures ?",
            "MDR le badge 'Machine à café', je le veux !"
        ];

        foreach ($posts as $post) {
            // Entre 2 et 5 commentaires par article
            for ($c = 0; $c < rand(2, 5); $c++) {
                $comment = new Comment();
                $comment->setContent($commentTexts[array_rand($commentTexts)]);
                $comment->setCreatedAt(new \DateTimeImmutable("-" . rand(1, 24) . " hours"));
                $comment->setUser($users[array_rand($users)]);
                $comment->setPost($post);
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}