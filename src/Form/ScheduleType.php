<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weekdays', TextType::class, ['label' => 'Weekdays'])
            ->add('openingHours', TextType::class, ['label' => 'Opening Hours'])
            ->add('closingHours', TextType::class, ['label' => 'Closing Hours']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Schedule',
        ]);
    }
}