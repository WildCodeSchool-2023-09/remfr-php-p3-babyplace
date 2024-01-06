<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamFirstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prenom de l\'equipier',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le prenom.',
                    ]),
                ],
            ])
            ->add('teamLastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de l\'equipier',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom.',
                    ]),
                ],
            ])
            ->add('fonction', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Fonction',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la fonction.',
                    ]),
                ],
            ])
            ->add('teamAvatarFile', VichFileType::class, [
                'label' => false,
                'required'      => false,
                'allow_delete'  => true,
                'download_uri' => true,
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Team',
        ]);
    }
}
