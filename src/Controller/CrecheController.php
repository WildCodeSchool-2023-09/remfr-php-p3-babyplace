<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Creche;
use App\Form\PhotoType;
use App\Form\Type\TeamType;
use App\Form\Type\CrecheType;
use App\Form\Type\ScheduleType;
use App\Repository\ChildRepository;
use App\Repository\CrecheRepository;
use App\Repository\FamilyRepository;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Type\RegistrationCrecheType;
use App\Repository\ReservationRepository;
use App\Repository\AdministrationRepository;
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
    Creche $creche): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('creche/editIndex.html.twig', [
            'creche' => $creche,
        ]);
    }

    #[Route('/gestion/info/{id}', methods: ['GET', 'POST'], name: 'edit_creche')]
    public function editCreche(Creche $creche, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(CrecheType::class, $creche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('creche_edit_index', ['id' => $creche->getId()]);
        }

        return $this->render('creche/edit/creche.html.twig', [
            'form' => $form->createView(),
            'creche' => $creche,
        ]);
    }

    #[Route('/gestion/planning/{id}', methods: ['GET', 'POST'], name: 'edit_schedule')]
    public function editSchedule(Creche $creche, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(ScheduleType::class, $creche->getSchedule());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('creche/edit/schedule.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestion/photo/{id}', methods: ['GET', 'POST'], name: 'edit_photo')]
    public function editPhoto(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('creche/edit/photos.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestion/equipe/{id}', methods: ['GET', 'POST'], name: 'edit_team')]
    public function editTeam(Creche $creche, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(TeamType::class, $creche->getTeams());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($creche);
            $entityManager->flush();

            return $this->redirectToRoute('registration_success');
        }

        return $this->render('creche/edit/team.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/demandes/{id}', methods: ['GET', 'POST'], name: 'demandes')]
    public function demandes(
        CrecheRepository $crecheRepository,
        FamilyRepository $familyRepository,
        ReservationRepository $reservationRepo,
        CalendarRepository $calendarRepository,
        ChildRepository $childRepository,
        AdministrationRepository $administrationRepo
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $creche = $crecheRepository->findOneBy(['user' => $this->getUser()]);
        $family = $familyRepository->findAll();
        //$reservation = $reservationRepo->findAll();
        $reservations = $reservationRepo->findBy([], ['id' => 'DESC']);
        $calendar = $calendarRepository->findAll();
        $children = $childRepository->findAll();
        $administration = $administrationRepo->findAll();

        return $this->render('creche/demandes.html.twig', [
            'reservations' => $reservations,
            'family' => $family,
        ]);
    }

    #[Route('/demandes/accepter/{id}', methods: ['GET', 'POST'], name: 'demande_accepter')]
    public function demandeAccepter(
        ReservationRepository $reservationRepo,
        EntityManagerInterface $entityManager,
        CrecheRepository $crecheRepository,
        int $id
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $creche = $crecheRepository->findOneBy(['user' => $this->getUser()]);
        $reservation = $reservationRepo->findOneBy(['id' => $id]);
        $reservation->setStatus('accepté');
        $entityManager->flush();

        return $this->redirectToRoute('creche_demandes', ['id' => $creche->getId()]);
    }

    #[Route('/demandes/refuser/{id}', methods: ['GET', 'POST'], name: 'demande_refuser')]
    public function demandeRefuser(
        ReservationRepository $reservationRepo,
        EntityManagerInterface $entityManager,
        CrecheRepository $crecheRepository,
        int $id
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $creche = $crecheRepository->findOneBy(['user' => $this->getUser()]);
        $reservation = $reservationRepo->findOneBy(['id' => $id]);
        $reservation->setStatus('refusé');
        $entityManager->flush();

        return $this->redirectToRoute('creche_demandes', ['id' => $creche->getId()]);
    }

    #[Route('/demandes/modifier/{id}', methods: ['GET', 'POST'], name: 'demande_modifier')]
    public function demandeModifier(
        ReservationRepository $reservationRepo,
        EntityManagerInterface $entityManager,
        CrecheRepository $crecheRepository,
        int $id
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $creche = $crecheRepository->findOneBy(['user' => $this->getUser()]);
        $reservation = $reservationRepo->findOneBy(['id' => $id]);
        $reservation->setStatus('en attente');
        $entityManager->flush();

        return $this->redirectToRoute('creche_demandes', ['id' => $creche->getId()]);
    }

    #[Route('/demandes/annuler/{id}', methods: ['GET', 'POST'], name: 'demande_annuler')]
    public function demandeAnnuler(
        ReservationRepository $reservationRepo,
        EntityManagerInterface $entityManager,
        CrecheRepository $crecheRepository,
        int $id
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $creche = $crecheRepository->findOneBy(['user' => $this->getUser()]);
        $reservation = $reservationRepo->findOneBy(['id' => $id]);
        $reservation->setStatus('annulé');
        $entityManager->flush();

        return $this->redirectToRoute('creche_demandes', ['id' => $creche->getId()]);
    }
}
