<?php
// src/Form/UserProfileType.php // 
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // On ne garde que le Nickname avec une petite contrainte de sécurité
            ->add('nickName', TextType::class, [
                'label' => 'Ton super Pseudo',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Laisse vide pour garder ton nom de code Maker',
                    'class' => 'form-control-neo' // Si tu veux appliquer ton style plus tard
                ],
                'constraints' => [
                    new Length(
                        max: 20, // Plus de flèche, plus de guillemets sur "max"
                        maxMessage: 'Oula ! 20 caractères maximum, c\'est déjà pas mal.'
                    ),
                ],
            ])
            // On ajoute l'option pour masquer l'alerte
            ->add('isHideNicknameWarning', CheckboxType::class, [
                'label' => 'Ne plus m\'avertir que mon email est visible sans pseudo',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}