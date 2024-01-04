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
        $builder
            ->add('introduction', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Presentation',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une presentation de votre crèche.',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de la crèche',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer le nom de votre crèche.',
                    ]),
                ],
            ])
            ->add('localisation', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre adresse.',
                    ]),
                ],
            ])
            ->add('postCode', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre code postal.',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre ville.',
                    ]),
                ],
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Telephone',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre numero de telephone.',
                    ]),
                ],
            ])
            ->add('insuranceNumber', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numero d\'assurance',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre numero d\'assurance.',
                    ]),
                ],
            ])
            ->add('legalStatus', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Statut juridique',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre statut juridique.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Creche',
        ]);
    }
}
