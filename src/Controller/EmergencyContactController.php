<?php

namespace App\Controller;

use App\Entity\EmergencyContact;
use App\Entity\Family;
use App\Form\EmergencyContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EmergencyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/emergency-contact', name: 'emergency_')]
class EmergencyContactController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function indexEmergency(EmergencyRepository $emergencyRepository): Response
    {
        return $this->render('emergency-contact/index.html.twig', [
            'emergency_contacts' => $emergencyRepository->findAll(),
        ]);
    }

    #[Route('/parent/{family_id}/new', name: 'new', methods: ['GET', 'POST'])]
    public function newEmergency(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping:['family_id' => 'id'])] Family $parent
    ): Response {
        $emergencyContact = new EmergencyContact();
        $form = $this->createForm(EmergencyContactFormType::class, $emergencyContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emergencyContact->setFamily($parent);
            $entityManager->persist($emergencyContact);
            $entityManager->flush();

            return $this->redirectToRoute('emergency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emergency-contact/new.html.twig', [
            'emergency_contact' => $emergencyContact,
            'form' => $form,
        ]);
    }

    #[Route('/parent/{family_id/emergency/{emergency_id}', name: 'show', methods: ['GET'])]
    public function showEmergency(
        #[MapEntity(mapping:['family_id' => 'id'])] Family $parent,
        #[MapEntity(mapping:['emergency_id' => 'id'])] EmergencyContact $emergencyContact
    ): Response {
        return $this->render('emergency-contact/show.html.twig', [
            'emergency_contact' => $emergencyContact,
            'family' => $parent,
        ]);
    }

    #[Route('parent/{family_id}/{emergency_id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editEmergency(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping:['family_id' => 'id'])] Family $parent,
        #[MapEntity(mapping:['emergency_id' => 'id'])] EmergencyContact $emergencyContact
    ): Response {
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

    #[Route('parent/{family_id}/{emergency_id}/delete', name: 'delete', methods: ['POST'])]
    public function deleteEmergency(
        Request $request,
        #[MapEntity(mapping:['family_id' => 'id'])] Family $parent,
        #[MapEntity(mapping:['emergency_id' => 'id'])] EmergencyContact $emergencyContact,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $emergencyContact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($emergencyContact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('emergency_index', [], Response::HTTP_SEE_OTHER);
    }
}
