<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

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

    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } elseif (in_array('ROLE_PARENT', $this->getUser()->getRoles()) && $this->getUser()->getFamily()) {
            return $this->redirectToRoute('parent_menu', ['id' => $this->getUser()->getFamily()->getId()]);
        }

        $family = new Family();
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Créer une entité family en récupérant l'id user créé à l'étape précédente
            $family->setUser($this->getUser());

            //Faire persister le parent
            $entityManager->persist($family);
            $entityManager->flush();

            //Il ne faudrait pas mettre de addFlash ici,
            //mais renvoyer à une page invitant à consulter ses mails
            return $this->redirectToRoute('parent_index');
        }

        return $this->render('parent/register-parent.html.twig', [
            'formFamily' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editParent(
        Request $request,
        Family $family,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($family);
            $entityManager->flush();

            $this->addFlash('familySuccess', 'Vos informations personnelles ont bien été mises à jour.');

            return $this->redirectToRoute('parent_menu');
        }

        $this->addFlash('familyFail', 'Il y a eu un problème dans la modification de vos informations.');

        return $this->render('parent/informations-personnelles.html.twig', [
            'formFamily' => $form,
            'family' => $family,
        ]);
    }

    //Voir le profil parent
    #[Route('/{id}/profil', methods: ['GET'], name: 'profil')]
    public function showProfil(Family $family): Response
    {
        return $this->render('parent/parent-profil.html.twig', [
            'parent' => $family,
        ]);
    }
    //Il faudrait qu'on édite cette méthode de façon à la link avec user,
    //de cette façon, le compte serait supprimé. Donc renvoi à la page d'accueil.
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function deleteParent(
        Request $request,
        Family $family,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        if (
            $this->isCsrfTokenValid('delete' . $family->getId() .
            '_' . $user->getId(), $request->request->get('_token'))
        ) {
            $entityManager->remove($family);
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('family_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/menu-parent', name: 'menu', methods:['GET'])]
    public function menuParent(): Response
    {
        return $this->render('parent/menu.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Listes de recherches
    #[Route('/liste-de-recherches', name: 'liste-de-recherches')]
    public function searchList(): Response
    {
        return $this->render('parent/search-list.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Recherches
    #[Route('/recherches', name: 'recherches')]
    public function search(): Response
    {
        return $this->render('parent/search.html.twig', [
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

    //Voir la page de réservation
    #[Route('/reservation', methods:['GET','POST'], name:'parent_reservation1')]
    public function showReservation(): Response
    {
        return $this->render('parent/reservation1-parent.html.twig', [
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

    // Dossiers d'inscriptions - Parents
    #[Route('/{id}/dossiers-inscriptions', name: 'dossiers-inscriptions')]
    public function foldersRegister(): Response
    {
        return $this->render('parent/dossiers-inscriptions.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Dossiers enfants - Parents
    #[Route('/dossiers-enfants', name: 'dossiers-enfants')]
    public function childRegister(): Response
    {
        return $this->render('parent/dossiers-enfants.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Dossiers parents - Parents
    #[Route('/dossiers-parents', name: 'dossiers-parents')]
    public function parentRegister(): Response
    {
        return $this->render('parent/dossiers-parents.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    // Informations personnelles - Parents
    /*#[Route('/informations-personnelles', name: 'informations-personnelles')]
    public function infosFamily(): Response
    {
        return $this->render('', [
            'controller_name' => 'FamilyController',
        ]);
    }*/

    // Réservations - Parents
    #[Route('/reservations', name: 'reservations')]
    public function reservations(): Response
    {
        return $this->render('parent/reservations.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/results', methods: ['GET'], name:'results')]
    public function showCrecheResults()
    {
        return $this->render('parent/presentation-creche.html.twig');
    }
}
