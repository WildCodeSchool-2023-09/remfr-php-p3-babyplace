<?php

namespace App\Form;

use App\Entity\Administration;
use App\Entity\Family;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FamilyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'placeholder' => 'Nom de famille',
                'label' => false,
                'attr' => [
                'placeholder' => 'Nom de famille',
                'class' => 'form-control',
                ],
                'constraints' =>
                    new notBlank(['message' => 'Veuillez indiquer votre nom de famille.'])
            ])
            ->add('firstname', TextType::class, [

                'placeholder' => 'Prénom',
                new notBlank(['message' => 'Veuillez indiquer votre prénom.'])
            ])
            ->add('address', TextType::class, [
                'placeholder' => 'Adresse',
                'constraints' =>
                new notBlank(['message' => 'Veuillez ajouter une adresse valide.'])
            ])
            ->add('postalCode', TextType::class, [
                'placeholder' => 'Code postal',
                'constraints' =>
                new notBlank(['message' => 'Veuillez inscrire votre code postal.']),
                new Length(['message' => '.'])
            ])
            ->add('city', TextType::class, [
                'placeholder' => 'Ville',
                'constraints' =>
                new notBlank(['message' => 'Veuillez ajouter votre ville.'])
            ])
            ->add('phone', TelType::class, [
                'placeholder' => 'Numéro de téléphone',
                'constraints' =>
                new notBlank(['message' => 'Veuillez saisir votre numéro de téléphone valide.'])

            ])
            /*->add('administration', EntityType::class, [
                'class' => Administration::class,
                'choice_label' => 'id',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Family::class,
        ]);
    }
}
