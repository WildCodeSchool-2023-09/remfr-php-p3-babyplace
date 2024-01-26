<?php

namespace App\Twig\Components;

use App\Form\ChildType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;

#[AsLiveComponent]
final class FormComponent extends AbstractController
{   
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    //fonction native PHP pour l'instanciation
    public function instantiateForm(): FormInterface
    {
        //Création d'un formulaire sans spécifier le chemin de ChildType
        return $this->createForm(ChildType::class);
    }
}
