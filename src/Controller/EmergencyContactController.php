<?php

namespace App\Controller;

use App\Entity\EmergencyContact;
use App\Form\EmergencyContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EmergencyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/emergency-contact', name: 'emergency_')]
class EmergencyContactController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EmergencyRepository $emergencyRepository): Response
    {
        return $this->render('emergency-contact/index.html.twig', [
            'emergency_contacts' => $emergencyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emergencyContact = new EmergencyContact();
        $form = $this->createForm(EmergencyContactFormType::class, $emergencyContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emergencyContact);
            $entityManager->flush();

            return $this->redirectToRoute('emergency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emergency-contact/new.html.twig', [
            'emergency_contact' => $emergencyContact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function showEmergency(EmergencyContact $emergencyContact): Response
    {
        return $this->render('emergency-contact/show.html.twig', [
            'emergency_contact' => $emergencyContact,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editEmergency(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emergencyContact = new EmergencyContact();
        $form = $this->createForm(EmergencyContactFormType::class, $emergencyContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('emergency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emergency-contact/edit.html.twig', [
            'emergencyForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function deleteEmergency(
        Request $request,
        EmergencyContact $emergencyContact,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $emergencyContact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($emergencyContact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('emergency_index', [], Response::HTTP_SEE_OTHER);
    }
}
