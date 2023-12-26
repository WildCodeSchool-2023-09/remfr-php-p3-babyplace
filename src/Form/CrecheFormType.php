<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrecheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('introduction', TextType::class, ['label' => 'Introduction'])
            ->add('name', TextType::class, ['label' => 'Name'])
            ->add('localisation', TextType::class, ['label' => 'Localisation'])
            ->add('postCode', IntegerType::class, ['label' => 'Post Code'])
            ->add('city', TextType::class, ['label' => 'City'])
            ->add('phoneNumber', TelType::class, ['label' => 'Phone Number'])
            ->add('insuranceNumber', TextType::class, ['label' => 'Insurance Number'])
            ->add('legalStatus', TextType::class, ['label' => 'Legal Status']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Creche',
        ]);
    }
}
