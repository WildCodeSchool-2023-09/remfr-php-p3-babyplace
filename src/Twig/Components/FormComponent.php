<?php

namespace App\Twig\Components;

use App\Entity\Child;
use App\Form\ChildType;
use App\Entity\Family;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent]
final class FormComponent extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(writable:true)]
    public ?Child $initialFormData = null;


    //fonction native PHP pour l'instanciation
    public function instantiateForm(): FormInterface
    {

        $child = $this->initialFormData ?? new Child();
        $family = $child->getFamily() ? $child->getFamily()->getId() : $this->getUser()->getFamily()->getId();

        //Création d'un formulaire sans spécifier le chemin de ChildType
        return $this->createForm(ChildType::class, $child, [
            'action' => $this->generateUrl('child_new', ['family_id' => $family])
        ]);
    }
}
