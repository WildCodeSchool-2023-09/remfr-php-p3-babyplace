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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Length;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

/**
 * This will suppress all the PMD warnings in
 * this class.
 *
 * @SuppressWarnings(PHPMD)
 */
class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $this->addChildFirstnameField($builder);
        $this->addChildLastnameField($builder);
        $this->addBirthdateField($builder);
        $this->addIsWalkingField($builder);
        $this->addAllergyField($builder);
        $this->addIsDisabledField($builder);
        $this->addDisabilityField($builder);
        $this->addBirthCertificateFileField($builder);
        $this->addDoctorNameField($builder);
        $this->addVaccineFileField($builder);
        $this->addInsuranceFileField($builder);
        $this->addFamilyField($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }

    private function addChildFirstnameField(DynamicFormBuilder $builder): void
    {
        $builder->add('childFirstname', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Prénom',
                'class' => 'form-text_dossiers-enfants',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez indiquer le prénom de votre enfant.']),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Le prénom de votre enfant doit être composé d\'au moins {{ limit }} caractères.'
                ])
            ]
        ]);
    }

    private function addChildLastnameField(DynamicFormBuilder $builder): void
    {
        $builder->add('childLastname', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Nom de famille',
                'class' => 'form-control',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez indiquer le nom de famille de votre enfant.']),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Le prénom doit être composé d\'au moins {{ limit }} caractères.'
                ])
            ]
        ]);
    }

    private function addBirthdateField(DynamicFormBuilder $builder): void
    {
        $builder->add('birthdate', DateType::class, [
            'widget' => 'choice',
            'label' => false,
            'attr' => [
                'placeholder' => 'Date de naissance',
                'class' => 'form-control',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez indiquer la date de naissance de votre enfant.']),
            ]
        ]);
    }

    private function addIsWalkingField(DynamicFormBuilder $builder): void
    {
        $builder->add('isWalking', ChoiceType::class, [
            'label' => false,
            'multiple' => false,
            'attr' => [
                'class' => 'form-control',
            ],
            'placeholder' => 'Votre enfant marche-t-il ?',
            'choices' => [
                'Oui' => true,
                'Non' => false,
            ],
        ]);
    }

    private function addAllergyField(DynamicFormBuilder $builder): void
    {
        $builder->add('allergy', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'Allergie',
                'class' => 'form-control',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez indiquer l\'allergie de votre enfant.']),
            ]
        ]);
    }

    private function addIsDisabledField(DynamicFormBuilder $builder): void
    {
        $builder->add('isDisabled', ChoiceType::class, [
            'label' => false,
            'multiple' => false,
            'required' => false,
            'attr' => [
                'class' => 'form-control',
            ],
            'placeholder' => 'Votre enfant présente-t-il un handicap',
            'choices' => [
                'Oui' => true,
                'Non' => false,
            ]
        ]);
    }

    private function addDisabilityField(DynamicFormBuilder $builder): void
    {
        $builder->addDependent(
            'disability',
            'isDisabled',
            function (DependentField $disabilityDepend, ?bool $isDisabledValue) {
                if ($isDisabledValue) {
                    $disabilityDepend->add(TextareaType::class, [
                        'label' => false,
                        'attr' => [
                            'class' => 'form-control',
                            'placeholder' => 'Quel est-il ?'
                        ],
                    ]);
                }
            }
        );
    }

    private function addBirthCertificateFileField(DynamicFormBuilder $builder): void
    {
        $builder->add('birthCertificateFile', VichFileType::class, [
            'label' => false,
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
        ]);
    }

    private function addDoctorNameField(DynamicFormBuilder $builder): void
    {
        $builder->add('doctorName', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Prénom et NOM du docteur',
                'class' => 'form-control',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez indiquer le Prénom et NOM de votre docteur.']),
            ]
        ]);
    }

    private function addVaccineFileField(DynamicFormBuilder $builder): void
    {
        $builder->add('vaccineFile', VichFileType::class, [
            'label' => false,
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
        ]);
    }

    private function addInsuranceFileField(DynamicFormBuilder $builder): void
    {
        $builder->add('insuranceFile', VichFileType::class, [
            'label' => false,
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
        ]);
    }

    private function addFamilyField(DynamicFormBuilder $builder): void
    {
        $builder->add('family', EntityType::class, [
            'class' => Family::class,
            'choice_label' => 'id',
        ]);
    }
}
