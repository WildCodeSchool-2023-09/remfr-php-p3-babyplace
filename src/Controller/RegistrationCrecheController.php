<?php

// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationCrecheController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegistrationFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission and entity persistence here
            // For example:
            $data = $form->getData();
            $creche = $data['creche'];
            $schedule = $data['schedule'];
            $team = $data['team'];

            // Persist entities to the database

            // Redirect to success page
            return $this->redirectToRoute('registration_success');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}