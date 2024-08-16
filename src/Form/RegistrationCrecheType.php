<?php

namespace App\Form;

use App\Form\PhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationCrecheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('creche', CrecheType::class)
            ->add('schedules', CollectionType::class, [
                'entry_type' => ScheduleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => '__name2__',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => '__name2__'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],
            ])
            ->add('photo', CollectionType::class, [
                'entry_type' => PhotoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => '__name2__',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => '__name2__'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],
            ])
            ->add('teams', CollectionType::class, [
                'entry_type' => TeamType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => '__name2__',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => '__name2__'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null, // This is important to allow handling multiple forms
        ]);
    }
}
