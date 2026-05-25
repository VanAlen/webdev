<?php

namespace App\Form;

use App\Entity\Gem;
use App\Entity\Gemtype;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GemsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('carat', NumberType::class, [
                'scale' => 2,
                'required' => true,
                'html5' => true,
                'attr' => [
                    'step' => '0.01',
                    'min' => '0.01'
                ]
            ])
            ->add('size', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'e.g. 7x5mm']
            ])
            
            // CUT - Dropdown (standard diamond/gem cuts)
            ->add('cut', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Round Brilliant' => 'Round Brilliant',
                    'Princess' => 'Princess',
                    'Emerald' => 'Emerald',
                    'Asscher' => 'Asscher',
                    'Marquise' => 'Marquise',
                    'Oval' => 'Oval',
                    'Radiant' => 'Radiant',
                    'Pear' => 'Pear',
                    'Heart' => 'Heart',
                    'Cushion' => 'Cushion',
                    'Trillion' => 'Trillion',
                    'Baguette' => 'Baguette',
                ],
                'placeholder' => 'Select cut type',
                'attr' => ['class' => 'form-input']
            ])
                        
            // COLOR - Professional labels, simple values
            ->add('color', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Red' => 'Red',
                    'Blue' => 'Blue', 
                    'Green' => 'Green',
                    'Yellow' => 'Yellow',
                    'Pink' => 'Pink',
                    'Purple' => 'Purple',
                    'Orange' => 'Orange',
                    'White' => 'White',
                ],
                'placeholder' => 'Select a color',  // ADD THIS
                'attr' => ['class' => 'form-input']
            ])

            // CLARITY - Professional labels, simple values
            ->add('clarity', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'FL Flawless' => 'FL',
                    'IF Internally Flawless' => 'IF',
                    'VVS1' => 'VVS1',
                    'VVS2' => 'VVS2', 
                    'VS1' => 'VS1',
                    'VS2' => 'VS2',
                    'SI1' => 'SI1',
                    'SI2' => 'SI2',
                    'I1' => 'I1',
                    'I2' => 'I2',
                    'I3' => 'I3',
                ],
                'placeholder' => 'Select a clarity',  // ADD THIS
                'attr' => ['class' => 'form-input']
            ])
            
            ->add('origin', TextType::class, ['required' => true])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('stock', NumberType::class, [
                'required' => true,
                'html5' => true,
                'attr' => ['min' => '0']
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'step' => '0.01',
                    'min' => '0.01'
                ]
            ])
            ->add('imagepath', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Gem Image'
            ])
            ->add('gemtype', EntityType::class, [
                'class' => Gemtype::class,
                'choice_label' => 'name',
                'required' => true,
                'placeholder' => 'Select a gem type'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gem::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'gems',
        ]);
    }
}