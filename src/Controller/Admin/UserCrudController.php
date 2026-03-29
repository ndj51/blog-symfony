<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email')->setDisabled(),
            ChoiceField::new('roles')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Éditeur' => 'ROLE_EDITOR',
                ])
                ->allowMultipleChoices()
                ->renderExpanded()
                ->renderAsBadges(),
            TextareaField::new('password'),
            TextField::new('nickName'),
            // Ce champ est "virtuel" : il affiche le résultat de getDisplayName()
            TextField::new('displayName', 'Nom affiché sur le site')
                ->onlyOnIndex(),
            BooleanField::new('isHideNicknameWarning', 'Alerte masquée'),
            AssociationField::new('badges', 'Badges de l\'utilisateur')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ]),
        ];
    }
    
}
