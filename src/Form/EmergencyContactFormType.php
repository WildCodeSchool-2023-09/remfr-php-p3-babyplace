<?php

namespace App\Form;

use App\Entity\EmergencyContact;
use App\Entity\Family;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class EmergencyContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Prénom
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control',
                ],
                'constraints' =>
                new NotBlank(['message' => 'Veuillez indiquer le prénom de la personne à contacter.']),
                new Assert\Length([
                    'min' => 2,
                    'minMessage' => 'Le prénom doit être composé d\'au moins {{ limit }} caractères.'
                ])
            ])
            // Nom
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control',
                ],
                'constraints' =>
                new NotBlank(['message' => 'Veuillez indiquer le nom de la personne à contacter.']),
                new Assert\Length([
                    'min' => 2,
                    'minMessage' => 'Le nom doit être composé d\'au moins {{ limit }} caractères.'
                ])
            ])
            // Téléphone
            ->add('phoneContact', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone',
                    'class' => 'form-control',
                ],
                'constraints' =>
                new NotBlank(['message' => 'Veuillez indiquer le numéro de téléphone de la personne à contacter.']),
            ])
            // Famille
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmergencyContact::class,
        ]);
    }
}
