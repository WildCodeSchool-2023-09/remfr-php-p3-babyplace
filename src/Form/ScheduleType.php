<?php

namespace App\Form\Type;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weekdays', ChoiceType::class, ['label' => 'Weekdays', 'choices' => Schedule::DAYS])
            ->add('openingHours', TimeType::class, ['label' => 'Opening Hours',])
            ->add('closingHours', TimeType::class, ['label' => 'Closing Hours']);
        foreach (Schedule::DAYS as $day) {
            $builder->add($day, CollectionType::class, [
                'entry_type' => TimeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => $day,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
