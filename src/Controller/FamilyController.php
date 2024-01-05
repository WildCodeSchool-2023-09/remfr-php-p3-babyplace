<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilyController extends AbstractController
{
    #[Route('/parent', name: 'parent')]
    public function index(): Response
    {
        return $this->render('parent/index.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/menu-parent', name: 'menu')]
    public function menuParent(): Response
    {
        return $this->render('parent/menu.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/recherches', name: 'recherches')]
    public function searchList(): Response
    {
        return $this->render('parent/search-list.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/confirmation-inscription', name: 'confirmation-inscription')]
    public function confirmationRegister(): Response
    {
        return $this->render('parent/confirmation-inscription.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/profil-parent', name: 'profil-parent')]
    public function profilParent(): Response
    {
        return $this->render('parent/profil-parent.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }
}
