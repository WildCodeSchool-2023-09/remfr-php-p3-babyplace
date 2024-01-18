<?php

namespace App\Controller;

use App\Entity\Family;
use App\Form\FamilyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parent', name: 'parent_')]
class FamilyController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('parent/index.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/new', methods: ['GET', 'POST'], name: 'parent_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $family = new Family();
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($family);
            $entityManager->flush();

            //Il ne faudrait pas mettre de addFlash ici,
            //mais renvoyer à une page invitant à consulter ses mails
            return $this->redirectToRoute('parent_new');
        }

        return $this->render('parent/register-parent.html.twig', [
            'formRegister' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'parent_edit', methods: ['GET', 'POST'])]
    public function editParent(Request $request, Family $family, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($family);
            $entityManager->flush();

            $this->addFlash('familySuccess', 'Vos informations personnelles ont bien été mises à jour.');

            return $this->redirectToRoute('');
        }

        $this->addFlash('familyFail', 'Il y a eu un problème dans la modification de vos informations.');

        return $this->render('parent/edit-parent.html.twig', [
            'formEdit' => $form
        ]);
    }

    //Voir le profil parent
    #[Route('/{id}/profil', methods: ['GET'], name: 'parent_profil')]
    public function showProfil(Family $family): Response
    {
        return $this->render('parent/parent-profil.html.twig', [
            'parent' => $family,
        ]);
    }
    //Il faudrait qu'on édite cette méthode de façon à la link avec user,
    //de cette façon, le compte serait supprimé. Donc renvoi à la page d'accueil.
    #[Route('/{id}', name: 'parent_delete', methods: ['POST'])]
    public function deleteParent(
        Request $request,
        Family $family,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $family->getId(), $request->request->get('_token'))) {
            $entityManager->remove($family);
            $entityManager->flush();
        }

        return $this->redirectToRoute('family_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/menu-parent', name: 'menu')]
    public function menuParent(): Response
    {
        return $this->render('parent/menu.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/recherches', name: 'recherches')]
    public function searchList(): Response
    {
        return $this->render('parent/search-list.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/confirmation-inscription', name: 'confirmation-inscription')]
    public function confirmationRegister(): Response
    {
        return $this->render('parent/confirmation-inscription.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/profil', name: 'profil')]
    public function profilParent(): Response
    {
        return $this->render('parent/profil-parent.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Filtres présents sur la partie Recherche - Parents
    #[Route('/filtres', name: 'filtres')]
    public function filtersParent(): Response
    {
        return $this->render('parent/filters.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Layout des dossiers d'inscriptions - Parents
    #[Route('/dossiers-inscriptions', name: 'dossiers-inscriptions')]
    public function foldersRegister(): Response
    {
        return $this->render('parent/dossiers-inscriptions.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Layout des dossiers d'inscriptions - Parents
    #[Route('/dossiers-enfants', name: 'dossiers-enfants')]
    public function childRegister(): Response
    {
        return $this->render('parent/dossiers-enfants.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }
}
