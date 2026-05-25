<?php

namespace App\Form;

use App\Entity\Orderitem;
use App\Entity\Gem;
use App\Entity\Jewelries;
use App\Entity\Gembundles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class OrderitemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Gem section
            ->add('gem', EntityType::class, [
                'class' => Gem::class,
                'choice_label' => 'description',
                'required' => false,
                'placeholder' => 'Select a gem',
                'attr' => ['class' => 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-forest gem-select']
            ])
            ->add('gem_quantity', NumberType::class, [
                'html5' => true,
                'required' => false,
                'mapped' => false,
                'data' => null, // Empty by default
                'empty_data' => null,
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                    'placeholder' => '0',
                    'class' => 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-forest gem-quantity'
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Quantity must be 0 or greater'
                    ])
                ],
                'label' => 'Gem Quantity',
                'label_attr' => ['class' => 'block text-sm font-medium text-forest mb-1']
            ])
            
            // Jewelry section
            ->add('jewelry', EntityType::class, [
                'class' => Jewelries::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Select jewelry',
                'attr' => ['class' => 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-forest jewelry-select']
            ])
            ->add('jewelry_quantity', NumberType::class, [
                'html5' => true,
                'required' => false,
                'mapped' => false,
                'data' => null, // Empty by default
                'empty_data' => null,
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                    'placeholder' => '0',
                    'class' => 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-forest jewelry-quantity'
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Quantity must be 0 or greater'
                    ])
                ],
                'label' => 'Jewelry Quantity',
                'label_attr' => ['class' => 'block text-sm font-medium text-forest mb-1']
            ])
            
            // Gem Bundle section
            ->add('gembundle', EntityType::class, [
                'class' => Gembundles::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Select gem bundle',
                'attr' => ['class' => 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-forest bundle-select']
            ])
            ->add('bundle_quantity', NumberType::class, [
                'html5' => true,
                'required' => false,
                'mapped' => false,
                'data' => null, // Empty by default
                'empty_data' => null,
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                    'placeholder' => '0',
                    'class' => 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-forest bundle-quantity'
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Quantity must be 0 or greater'
                    ])
                ],
                'label' => 'Bundle Quantity',
                'label_attr' => ['class' => 'block text-sm font-medium text-forest mb-1']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orderitem::class,
        ]);
    }
}