<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\Creche;
use App\Entity\Family;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('childFirstname', TextType::class, $this->getTextFieldConfig('Prénom'))
            ->add('childLastname', TextType::class, $this->getTextFieldConfig('Nom de famille'))
            ->add('birthdate', DateType::class, $this->getDateFieldConfig('Date de naissance'))
            ->add('isWalking', CheckboxType::class, $this->getCheckboxConfig('Votre enfant marche-t-il ?'))
            ->add('allergy')
            ->add('isDisabled', CheckboxType::class, $this->getCheckboxConfig('Votre enfant présente-t-il un handicap ?'))
            ->add('disability', TextType::class, $this->getTextFieldConfig('Si oui, quel est-il ?', ['required' => false]))
            ->add('birthCertificate', FileType::class, $this->getFileConfig('Certificat de naissance'))
            ->add('doctorName', TextType::class, $this->getTextFieldConfig('Prénom et NOM du docteur'))
            ->add('vaccine', FileType::class, $this->getFileConfig('Carnet de vaccination'))
            ->add('insurance', FileType::class, $this->getFileConfig('Attestation d\'assurance de l\'enfant'))
            ->add('family', EntityType::class, $this->getEntityConfig(Family::class, 'id'))
            ->add('creche', EntityType::class, $this->getEntityConfig(Creche::class, 'id', ['multiple' => true]));

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $this->handleDisabilityField($data, $form);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }

    private function getTextFieldConfig(string $label, array $options = []): array
    {
        return [
            'label' => $label,
            'attr' => ['class' => 'form-control'],
            'constraints' => 
            [new NotBlank([
                'message' => "Veuillez indiquer $label."
                ])
            ],
            'class' => 'form-control',
            'constraints' => [new Length(['min' => 2, 'minMessage' => "$label doit être composé d'au moins {{ limit }} caractères."])],
            'required' => true,
        ] + $options;
    }

    private function getDateFieldConfig(string $label, array $options = []): array
    {
        return [
            'widget' => 'choice',
            'label' => $label,
            'class' => 'form-control',
            'constraints' => [new NotBlank(['message' => "Veuillez indiquer $label."])],
            'required' => true,
        ] + $options;
    }

    private function getCheckboxConfig(string $label, array $options = []): array
    {
        return [
            'label' => $label,
            'class' => 'form-control',
            'constraints' => [new NotBlank(['message' => "Veuillez préciser si $label."])],
            'required' => true,
        ] + $options;
    }

    private function getFileConfig(string $label, array $options = []): array
    {
        return [
            'label' => $label,
            'required' => true,
            'allow_delete' => true,
            'download_uri' => true,
        ] + $options;
    }

    private function getEntityConfig(string $class, string $label, array $options = []): array
    {
        return [
            'class' => $class,
            'choice_label' => $label,
        ] + $options;
    }

    private function handleDisabilityField(array $data, $form): void
    {
        $isDisabled = isset($data['isDisabled']) && $data['isDisabled'];
        $form->add('disability', TextType::class, [
            'required' => $isDisabled,
            'constraints' => [new NotBlank(['message' => 'Veuillez préciser la situation de votre enfant.'])],
            'class' => 'form-control',
        ]);
    }
}
