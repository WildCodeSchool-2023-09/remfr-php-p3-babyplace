<?php

namespace App\Controller;

use App\Entity\Creche;
use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CrecheRepository;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/calendar')]
//#[IsGranted('ROLE_ADMIN')]
class CalendarController extends AbstractController
{
    #[Route('/', name: 'app_calendar_index', methods: ['GET'])]
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_calendar_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        CrecheRepository $crecheRepository
    ): Response {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        $creche = $crecheRepository->findOneBy(['user' => $this->getUser()]);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendar->setCreche($creche);
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('app_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_calendar_show', methods: ['GET'])]
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_calendar_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Calendar $calendar,
        EntityManagerInterface $entityManager
    ): Response {

        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_calendar_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Calendar $calendar,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $calendar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($calendar);
            $entityManager->flush();
        }

        return $this->redirectToRoute(
            'app_agenda',
            ['id' => $calendar->getCreche()->getId()],
            Response::HTTP_SEE_OTHER
        );
    }
}
