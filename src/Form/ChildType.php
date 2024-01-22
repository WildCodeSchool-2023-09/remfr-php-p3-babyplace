<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\Creche;
use App\Entity\Family;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\Length;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('childFirstname', TextType::class, [
                'label' => 'Prénom',
                'class' => 'form-control',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer le prénom de votre enfant.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le prénom de votre enfant doit être composé
                         d\'au moins {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('childLastname', TextType::class, [
                'label' => 'Nom de famille',
                'class' => 'form-control',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer le nom de famille de votre enfant.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le prénom doit être composé d\'au moins {{ limit }} caractères.'
                    ])
                ]
            ])
            // Date de naissance
            ->add('birthdate', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date de naissance',
                'class' => 'form-control',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer la date de naissance de votre enfant.']),
                ]
            ])
            ->add('isWalking', CheckboxType::class, [
                'label' => 'Votre enfant marche-t-il ?',
                'class' => 'form-control',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez préciser si votre enfant marche.']),
                ]
            ])
            ->add('allergy')
            ->add('isDisabled', CheckboxType::class, [
                'label' => 'Votre enfant présente-t-il un handicap ?',
                'class' => 'form-control',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez préciser la situation de votre enfant.']),
                ]
            ])
            ->add('disability', TextType::class, [
                'label' => 'Si oui, quel est-il ?',
                'required' => false,
                'class' => 'form-control',
            ])
            ->add('birthCertificate', VichFileType::class, [
                'label' => 'Certificat de naissance',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('doctorName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom et NOM du docteur',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer le Prénom et NOM de votre docteur.']),
                ]
            ])
            ->add('vaccine', VichFileType::class, [
                'label' => 'Carnet de vaccination',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('insurance', VichFileType::class, [
                'label' => 'Attestation d\'assurance de l\'enfant',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'id',
            ])
            ->add('creche', EntityType::class, [
                'class' => Creche::class,
                'choice_label' => 'id',
                'multiple' => true,
            ]);

            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                // Vérifier si 'isDisabled' est vrai
                $isDisabled = isset($data['isDisabled']) && $data['isDisabled'];

                // Rendre 'disability' obligatoire si 'isDisabled' est vrai
                $form->add('disability', TextType::class, [
                    'required' => $isDisabled,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez préciser la situation de votre enfant.']),
                    ],
                    'class' => 'form-control',
                ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
