<?php

namespace App\Controller;

use App\Form\Type\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationCrecheController extends AbstractController
{
    #[Route('/registration', methods: ['GET', 'POST'], name: 'registration')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);

            // Créez et persistez la crèche
            $creche = $data['creche'];
            $entityManager->persist($creche);

            // Créez et persistez l'horaire
            $schedule = $data['schedule'];
            $schedule->setCreche($creche);
            $entityManager->persist($schedule);

            // Créez et persistez l'équipe
            $team = $data['team'];
            $team->setCreche($creche);

            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('registration_creche/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
