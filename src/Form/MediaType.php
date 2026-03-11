<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'constraints' => [
                    new File(
                        maxSize: '8M',
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                    )
                ],
            ])
            // Modification ici : on utilise 'fileName' (le nom de la propriété dans l'entité)
            ->add('fileName', TextType::class, [
                'label' => 'Nom du fichier stocké (pour votre Markdown)',
                'required' => false,
                'attr' => [
                    'readonly' => true, 
                    'placeholder' => 'Apparaîtra après l\'enregistrement',
                    'style' => 'background-color: #f4f4f4; color: #555;'
                ],
                'help' => 'Copiez ce nom pour vos liens : /uploads/media/NOM_DU_FICHIER',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}