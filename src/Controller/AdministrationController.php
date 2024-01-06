<?php

namespace App\Controller;

use App\Entity\Administration;
use App\Form\AdministrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Flex\Response as FlexResponse;

#[Route('/administration', name: 'administration_')]
class AdministrationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('dashboard-creche.html.twig');
    }

    #[Route('/add', name:'add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        //Création d'un nouvel objet administratif
        $administration = new Administration();
        //Ajouter un lien avec le formulaire associé
        $form = $this->createForm(AdministrationType::class, $administration);
        //Récupération de la data issue du HTTP Request
        $form->handleRequest($request);
        //A la soumission du formulaire
        if ($form->isSubmitted()) {
            $entityManager->persist($administration);
            $entityManager->flush();
        }

        return $this->render('administration/index.html.twig', [
            'form' => $form,
        ]);
    }
}
