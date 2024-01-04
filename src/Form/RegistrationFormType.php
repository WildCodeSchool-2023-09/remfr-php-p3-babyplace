<?php

namespace App\Form\Type;

use App\Form\PhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('creche', CrecheType::class)
            ->add('schedules', ScheduleType::class)
            ->add('photo', PhotoType::class)
            ->add('team', TeamType::class);
    }
    /*{
        $builder
            ->add('creche', CrecheType::class)
            ->add('photo', PhotoType::class)
            ->add('schedules', CollectionType::class, [
                'entry_type' => ScheduleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__schedule__',
                'by_reference' => false,
            ])
            ->add('team', TeamType::class);
    }*/


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null, // This is important to allow handling multiple forms
        ]);
    }
}
