<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\MediaType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre de l\'article')->setColumns(12),
            AssociationField::new('category', 'Catégorie')->setColumns(6),
            
            TextareaField::new('summary', 'Résumé (Extrait)')->setColumns(12),

            // Zone d'upload (Uniquement dans le formulaire)
            CollectionField::new('media', 'Ajouter des images')
                ->setEntryType(MediaType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms()
                ->setColumns(12),

            // Zone de rédaction
            TextareaField::new('content', 'Contenu (Markdown)')
                ->setColumns(12)
                ->setFormTypeOptions(['attr' => ['rows' => 15]]),

            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
        ];
    }
}