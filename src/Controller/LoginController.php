<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//Donne les méthodes de sécurisation et de vérification des données.
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LoginType;

class LoginController extends AbstractController
{
    #[Route('/login', methods: ['GET', 'POST'], name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        //Méthode se trouvant dans l'objet authenticationUtils pour la gestion des erreurs
        $error = $authenticationUtils->getLastAuthenticationError();
        //getLastUsername -> récupère la dernière valeur entrée pour se connecter, même email
        $lastEmail = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupération des données du formulaire
            //$formData = $form->getData();

            return $this->redirectToRoute('accueil');
        }


        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'lastEmail' => $lastEmail,
            'error' => $error,
            'form' => $form
        ]);
    }
}
