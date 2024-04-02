<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\Family;
use App\Entity\Reservation;
use App\Form\ChildType;
use App\Form\SearchChildType;
use App\Repository\ChildRepository;
use App\Repository\ReservationRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/child', name: 'child_')]
class ChildController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function indexChildren(ChildRepository $childRepository): Response
    {
        return $this->render('child/index-child.html.twig', [
            'children' => $childRepository->findAll(),
        ]);
    }

    #[Route('/{family_id}/new', name: 'new', methods: ['GET', 'POST'])]
    public function newChild(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['family_id' => 'id'])] Family $family,
    ): Response {
        $child = new Child();
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $child->setFamily($family);
            $entityManager->persist($child);
            $entityManager->flush();

            return $this->redirectToRoute(
                'parent_dossiers-inscriptions',
                ['family_id' => $family->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('child/new-child.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/parent/{family_id}/child/{child_id}', name: 'show', methods: ['GET'])]
    public function showChild(
        #[MapEntity(mapping:['family_id' => 'id'])] Family $parent,
        #[MapEntity(mapping:['child_id' => 'id'])]Child $child
    ): Response {
        return $this->render('child/show-child.html.twig', [
            'family' => $parent,
            'child' => $child,
        ]);
    }

    #[Route('/parent/{family_id}/child/{child_id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editChild(
        Request $request,
        Child $child,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('child_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('child/edit-child.html.twig', [
            'child_edit' => $child,
            'form' => $form,
        ]);
    }

    #[Route('/parent/{family_id}/child/{child_id}/delete', name: 'delete', methods: ['POST','GET'])]
    public function deleteChild(
        #[MapEntity(mapping: ['family_id' => 'id'])] Family $parent,
        #[MapEntity(mapping: ['child_id' => 'id'])] Child $child,
        EntityManagerInterface $entityManager,
    ): Response {

        $entityManager->remove($child);
        $entityManager->flush();

        return $this->redirectToRoute(
            'parent_dossiers-inscriptions',
            ['family_id' => $parent->getId()],
            Response::HTTP_SEE_OTHER
        );
    }

    #[Route('/search-child', name: 'search', methods: ['GET'])]
    public function searchChildren(Request $request, ChildRepository $childRepository): Response
    {
        $form = $this->createForm(SearchChildType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $data = $form->getData();

            //Effectuer la 1e requête
            $result1 = $childRepository->findLikeName($data);

            // Effectuer la deuxième requête
            $result2 = $childRepository->findDisability();

            return $this->render('your_template.html.twig', [
                'result1' => $result1,
                'result2' => $result2,
            ]);
        }

        return $this->render('your_search_form_template.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
