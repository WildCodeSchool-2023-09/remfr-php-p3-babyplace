<?php

namespace App\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teamFirstname', TextType::class, ['label' => 'First Name'])
            ->add('teamLastname', TextType::class, ['label' => 'Last Name'])
            ->add('fonction', TextType::class, ['label' => 'Function'])
            ->add('photo', FileType::class, ['label' => 'Photo'])
            ->add('creche', EntityType::class, [
                'class' => 'App\Entity\Creche',
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Team',
        ]);
    }
}