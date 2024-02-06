<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CrecheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $commonOptions = [
            'label' => false,
            'attr' => ['class' => 'form-text_informations-personnelles-creche'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire.',
                ]),
            ],
        ];

        $builder
            ->add('name', TextType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Nom de la crèche',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('introduction', TextareaType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Presentation',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('localisation', TextType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('postCode', IntegerType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('city', TextType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('phoneNumber', TelType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Telephone',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('insuranceNumber', TextType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Numero d\'assurance',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('legalStatus', TextType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Statut juridique',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]))
            ->add('rules', TextType::class, array_merge($commonOptions, [
                'attr' => [
                    'placeholder' => 'Règlement intérieur',
                    'class' => 'form-text_informations-personnelles-creche'
                ],
            ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Creche',
        ]);
    }
}
