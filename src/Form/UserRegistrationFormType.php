<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_CONTRIBUTOR' => 'ROLE_USER',
                    'ROLE_CRECHE' => 'ROLE_CONTRIBUTOR',
                    'ROLE_FAMILY' => 'ROLE_CONTRIBUTOR',
                    'ROLE_ADMIN' => 'ROLE_CONTRIBUTOR',
                    // Ajoutez d'autres rôles au besoin
                ],
                'label' => 'Rôles', // Label du champ
                'expanded' => true, // Optionnel : afficher les choix sous forme de boutons radio
                'multiple' => true, // Optionnel : permettre la sélection multiple
            ])
            ->add('email', EmailType::class, [
                //permet de mettre les champs en français:
                'placeholder' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse email valide.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'placeholder' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('avatar', VichFileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'allow_delete'  => true,
                'download_uri' => true,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions d\'utilisation
                         afin de continuer votre inscription.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
