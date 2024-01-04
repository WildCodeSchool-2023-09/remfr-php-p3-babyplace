<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CrecheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $commonOptions = [
            'label' => false,
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire.',
                ]),
            ],
        ];

        $builder
            ->add('introduction', TextType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Presentation'],
            ]))
            ->add('name', TextType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Nom de la crèche'],
            ]))
            ->add('localisation', TextType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Adresse'],
            ]))
            ->add('postCode', IntegerType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Code postal'],
            ]))
            ->add('city', TextType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Ville'],
            ]))
            ->add('phoneNumber', TelType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Telephone'],
            ]))
            ->add('insuranceNumber', TextType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Numero d\'assurance'],
            ]))
            ->add('legalStatus', TextType::class, array_merge($commonOptions, [
                'attr' => ['placeholder' => 'Statut juridique'],
            ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Creche',
        ]);
    }
}
