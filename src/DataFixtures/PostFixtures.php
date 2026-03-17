<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. Création de quelques catégories de test
        $categories = [];
        $names = ['Tech', 'Design', 'Actualité'];

        foreach ($names as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category; // On les stocke pour plus tard
        }

        // 2. Création de 10 articles
        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
            $post->setTitle("Mon super article n°$i");
            $post->setContent("Contenu détaillé de l'article $i pour le blog Symfony.");
            $post->setSummary("Résumé court de l'article $i.");
            $post->setCreatedAt(new \DateTimeImmutable());
            
            // On pioche une catégorie au hasard parmi les 3 créées
            $randomCategory = $categories[array_rand($categories)];
            $post->setCategory($randomCategory);

            $manager->persist($post);
        }

        // 3. Envoi définitif en base de données
        $manager->flush();
    }
}