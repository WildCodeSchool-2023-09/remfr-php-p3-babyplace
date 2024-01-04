<?php

namespace App\Controller;

use App\Entity\Family;
use App\Form\FamilyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilyController extends AbstractController
{
    #[Route('/family', name: 'app_family')]
    public function index(): Response
    {
        return $this->render('family/index.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('', name:'')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $family = new Family();
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($family);
            $entityManager->flush();

            //return $this->redirectToRoute('');
        }

        return $this->render('', [
            'form' => $form,
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
}
