<?php
// src/Form/ContactType.php // 
namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', null, [
                  'label' => 'Votre Nom',
                  'attr' => ['class' => 'form-control',
                             'placeholder' => 'Jean Dupont']
            ])
            ->add('email', null, [
                  'label' => 'Votre Email',
                  'attr' => ['class' => 'form-control',
                             'placeholder' => 'jean@exemple.fr']
            ])
            ->add('subject', null, [
                  'label' => 'Sujet',
                  'attr' => ['class' => 'form-control']
            ])
            ->add('content', null, [
                  'label' => 'Message',
                  'attr' => ['class' => 'form-control',
                             'rows' => 5]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
