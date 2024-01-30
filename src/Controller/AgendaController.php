<?php

namespace App\Controller;

use App\Entity\Creche;
use App\Repository\CrecheRepository;
use App\Repository\CalendarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgendaController extends AbstractController
{
    #[Route('creche/gestion/agenda/{id}', name: 'app_agenda')]
    public function index(
        Creche $creche,
        CalendarRepository $calendarRepository,
        int $id,
        CrecheRepository $crecheRepository
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $events = $calendarRepository->findAll();
        $creche = $creche->getId();
        $rdvs = [];
        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'crecheId' => $creche,
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllDay(),
            ];
        }

        $data = json_encode($rdvs);
        return $this->render('agenda/agenda.html.twig', compact('data'));
    }

    #[Route('/creneaux', name: 'app_creneaux')]
    public function listReservation(CalendarRepository $calendarRepository): Response
    {
        $events = $calendarRepository->findAll();

        return $this->render('agenda/creneaux.html.twig', [
            "events" => $events
        ]);
    }
}
