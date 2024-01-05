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

class AdministrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('familyIncomeFile', VichFileType::class, [
            'label' => 'Justificatif de revenu',
            'required' => true,
            'allow_delete' => true,
            'download_uri' => true,
            ])
            ->add('taxReturnFile', VichFileType::class, [
                'label' => 'Déclaration de revenu',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('cafNumber', TextType::class, [
                'label' => 'Numéro CAF'
            ])
            ->add('socialNumber', TextType::class, [
                'label' => 'Numéro de sécurité sociale',
                'constraints'
            ])
            ->add('residencyProofFile', VichFileType::class, [
                'label' => 'Justificatif de domicile',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('statusProofFile', VichFileType::class, [
                'label' => 'Justificatif de revenu',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('bankingInfo', TextType::class, [
                'label' => 'RIB'
            ])
            ->add('discharge', VichFileType::class, [
                'label' => 'Autorisation de sortie',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('familyRecord', VichFileType::class, [
                'label' => 'Copie du livret de famille',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('divorceDecree', VichFileType::class, [
                'label' => 'Jugement de divorce',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                ])
            ->add('parent', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'id',
            ])
            ->add('creche', EntityType::class, [
                'class' => Creche::class,
                'choice_label' => 'id',
                'multiple' => true,
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
