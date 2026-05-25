<?php

namespace App\Form;

use App\Entity\Jewelries;
use App\Entity\Gemtype;
use App\Entity\Jewelrytype;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JewelriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'border rounded p-2 w-full'],
            ])
            ->add('gemtype', EntityType::class, [
                'class' => Gemtype::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a gem type',
                'attr' => ['class' => 'border rounded p-2 w-full'],
            ])
            ->add('jewelrytype', EntityType::class, [
                'class' => Jewelrytype::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a jewelry type',
                'attr' => ['class' => 'border rounded p-2 w-full'],
            ])
            ->add('price', NumberType::class, [
                'attr' => ['class' => 'border rounded p-2 w-full'],
            ])
            ->add('stock', NumberType::class, [
                'attr' => ['class' => 'border rounded p-2 w-full'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Upload Image',
                'mapped' => false, // ✅ handled manually in controller
                'required' => false,
                'attr' => ['class' => 'border rounded p-2 w-full'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jewelries::class,
        ]);
    }
}
