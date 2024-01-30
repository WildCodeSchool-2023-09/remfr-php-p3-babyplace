<?php

namespace App\Form;

use App\Entity\Administration;
use App\Entity\Creche;
use App\Entity\Family;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class AdministrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('familyIncomeFile', VichFileType::class, [
            'label' => false,
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            ])
            ->add('taxReturnFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('cafNumber', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro authentification CAF',
                ],
                'constraints' => [
                    new Assert\Length([
                        'min' => 7,
                        'max' => 7,
                        'exactMessage' => 'Le numéro de sécurité sociale doit
                         comporter exactement {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('socialNumber', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro de sécurité sociale',
                ],
                'constraints'  => [
                    new Assert\Length([
                        'min' => 15,
                        'max' => 15,
                        'exactMessage' => 'Le numéro de sécurité sociale doit
                         comporter exactement {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Le numéro de sécurité sociale ne doit contenir que des chiffres.',
                    ]),
                ],
            ])
            ->add('residencyProofFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('statusProofFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('bankingInfo', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre RIB',
                ],
                'constraints' => [
                    new Assert\Length([
                        'min' => 27,
                        'max' => 27,
                        'exactMessage' => 'Le RIB doit être composé de {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('dischargeFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('familyRecordFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('divorceDecreeFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('parent', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'id',
                'label' => false,
            ])
            ->add('creche', EntityType::class, [
                'class' => Creche::class,
                'choice_label' => 'id',
                'multiple' => true,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Administration::class,
        ]);
    }
}
