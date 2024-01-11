<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Creche;
use App\Form\PhotoType;
use App\Form\Type\TeamType;
use App\Form\Type\CrecheType;
use App\Form\Type\ScheduleType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Type\RegistrationCrecheType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/creche', name: 'creche_')]
class CrecheController extends AbstractController
{
    #[Route('/inscription', methods: ['GET', 'POST'], name: 'registration')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } elseif (in_array('ROLE_CRECHE', $this->getUser()->getRoles()) && $this->getUser()->getCreche()) {
            return $this->redirectToRoute('creche_edit_index', ['id' => $this->getUser()->getCreche()->getId()]);
        }
        $form = $this->createForm(RegistrationCrecheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Créez et persistez la crèche
            $creche = $data['creche'];
            $creche->setUser($this->getUser());
            $entityManager->persist($creche);

            // Créez et persistez les photos
            $photos = $data['photo'];
            foreach ($photos as $photo) {
                $photo->setCreche($creche);
                $entityManager->persist($photo);
            }

            // Créez et persistez l'horaire
            $schedules = $data['schedules'];
            foreach ($schedules as $schedule) {
                $schedule->setCreche($creche);
                $entityManager->persist($schedule);
            }

            // Créez et persistez l'équipe
            foreach ($data['teams'] as $team) {
                $team->setCreche($creche);
                $entityManager->persist($team);
            }
            $entityManager->flush();

            return $this->redirectToRoute('creche_edit_index', ['id' => $creche->getId()]);
        }

        return $this->render('registration_creche/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestion/{id}', methods: ['GET'], name: 'edit_index')]
    public function editIndex(#[MapEntity(mapping: ['id' => 'id'])]
        Creche $creche, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('creche/editIndex.html.twig', [
            'creche' => $creche,
        ]);
    }

    #[Route('/gestion/info/{id}', methods: ['GET', 'POST'], name: 'edit_creche')]
    public function editCreche(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CrecheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $creche = $data['creche'];
            $entityManager->persist($creche);

            return $this->redirectToRoute('registration_success');
        }
        return $this->render('creche/edit/creche.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestion/planning/{id}', methods: ['GET', 'POST'], name: 'edit_schedule')]
    public function editSchedule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScheduleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $schedule = $data['schedule'];
            $entityManager->persist($schedule);

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('creche/edit/schedule.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestion/photo/{id}', methods: ['GET', 'POST'], name: 'edit_photo')]
    public function editPhoto(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $photo = $data['photo'];
            $entityManager->persist($photo);

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('creche/edit/photos.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestion/equipe/{id}', methods: ['GET', 'POST'], name: 'edit_team')]
    public function editTeam(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $team = $data['team'];
            $entityManager->persist($team);

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('creche/edit/team.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
