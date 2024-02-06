<?php

namespace App\Controller;

use DateTime;
use App\Entity\Creche;
use App\Entity\Calendar;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    private CalendarRepository $calendarRepository;
    // création d'un construct pour éviter d'avoir à injecter dans la private function
    public function __construct(CalendarRepository $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    #[Route('/rdv/{id}/edit', name: 'rdv_event_edit', methods: ['PUT'])]
    public function majEvent(?Calendar $calendar, Request $request, EntityManagerInterface $entityManager): Response
    {
         // on récupère les données

         $donnees = json_decode($request->getContent());

         $calendar->setTitle($donnees->title);
         $calendar->setDescription($donnees->description);
         $calendar->setStart(new DateTime($donnees->start));
        if ($donnees->allDay) {
            $calendar->setEnd(new DateTime($donnees->start));
        } else {
            $calendar->setEnd(new DateTime($donnees->end));
        }
         $calendar->setAllDay($donnees->allDay);
         $calendar->setBackgroundColor($donnees->backgroundColor);
         $calendar->setTextColor($donnees->textColor);
         $calendar->setTitle($donnees->title);

         $entityManager->persist($calendar);
         $entityManager->flush();

        $data = $this->allEvent(/*$calendar*/);

         return $this->render('agenda/agenda.html.twig', compact('data'));
    }

    private function allEvent(): string
    {

        $events = $this->calendarRepository->findAll();
        //$creche = new Creche();
        //$var = $creche->getId();

        $rdvs = [];

        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'crecheId' => 1,
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

         return $data;
    }
}
