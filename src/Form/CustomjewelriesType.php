<?php

namespace App\Form;

use App\Entity\Customjewelries;
use App\Entity\Gemtype;
use App\Entity\Jewelrytype;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CustomjewelriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gemtype', EntityType::class, [
                'class' => Gemtype::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a gem type',
                'required' => false,
                'attr' => ['class' => 'w-full rounded-md border-gray-300 bg-gray-50 p-2 text-black']
            ])
            ->add('jewelrytype', EntityType::class, [
                'class' => Jewelrytype::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a jewelry type',
                'required' => false,
                'attr' => ['class' => 'w-full rounded-md border-gray-300 bg-gray-50 p-2 text-black']
            ])
            ->add('notes', TextareaType::class, [
                'attr' => [
                    'class' => 'w-full rounded-md border-gray-300 bg-gray-50 p-2 text-black',
                    'rows' => 4
                ],
                'label' => 'Notes / Description',
                'required' => false
            ])
            ->add('imagepath', FileType::class, [
                'label' => 'Upload Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, GIF, WEBP)',
                    ])
                ],
                'attr' => ['class' => 'w-full rounded-md border-gray-300 bg-gray-50 p-2 text-black']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customjewelries::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'customjewelries',
        ]);
    }
}