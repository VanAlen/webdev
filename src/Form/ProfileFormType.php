<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name', 
                'required' => false
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name', 
                'required' => false
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age', 
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label' => 'Address', 
                'required' => false
            ])
            ->add('profileImageFile', FileType::class, [
                'label' => 'Profile Image',
                'required' => false,
                'mapped' => false,
                'attr' => ['accept' => 'image/*']
            ]);
        
        if ($options['is_admin']) {
            $builder->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Active' => 'active',
                    'Pending' => 'pending',
                    'Suspended' => 'suspended'
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_admin' => false,
        ]);
    }
}