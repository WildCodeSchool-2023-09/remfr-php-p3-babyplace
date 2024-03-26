<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Child;
use App\Entity\Creche;
use App\Entity\Family;
use App\Entity\Calendar;
use App\Form\FamilyType;
use App\Form\CalendarType;
use App\Entity\Reservation;
use App\Repository\ChildRepository;
use App\Repository\CrecheRepository;
use App\Repository\FamilyRepository;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        EntityManagerInterface $entityManager,
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

    #[Route('/{id}/menu-parent', name: 'menu', methods: ['GET', 'POST'])]
    public function menuParent(FamilyRepository $familyRepository): Response
    {
        $family = $familyRepository->findOneBy(['id' => $this->getUser()->getFamily()->getId()]);
        return $this->render('parent/menu.html.twig', [
            'controller_name' => 'FamilyController',
            'family' => $family,
        ]);
    }

    // Listes de recherches
    #[Route('/{id}/liste-de-recherches', name: 'liste-de-recherches')]
    public function searchList(FamilyRepository $familyRepository, CrecheRepository $crecheRepository): Response
    {
        $family = $familyRepository->findOneBy(['id' => $this->getUser()->getFamily()->getId()]);
        $creches = $crecheRepository->findAll();
        return $this->render('parent/search-list.html.twig', [
            'controller_name' => 'FamilyController',
            'family' => $family,
            'creches' => $creches,
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

    // Filtres présents sur la partie Recherche - Parents
    #[Route('/filtres', name: 'filtres')]
    public function filtersParent(): Response
    {
        return $this->render('parent/filters.html.twig', [
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
    #[Route('/reservations', methods: ['GET', 'POST'], name: 'reservation1')]
    public function showReservation(FamilyRepository $familyRepository): Response
    {
        $family = $familyRepository->findOneBy(['id' => $this->getUser()->getFamily()->getId()]);

        return $this->render('parent/reservations.html.twig', [
            'controller_name' => 'FamilyController',
            'family' => $family
        ]);
    }

    // Dossiers d'inscriptions - Parents
    #[Route('/{family_id}/dossiers-inscriptions', name: 'dossiers-inscriptions')]
    public function foldersRegister(ChildRepository $childRepository): Response
    {
        $child = $childRepository->findAll();
        return $this->render('parent/dossiers-inscriptions.html.twig', [
            'controller_name' => 'FamilyController',
            'childs' => $child
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
    /*#[Route('/reservations/{id}', name: 'reservations')]
    public function reservations(EntityManagerInterface $entityManager, Request $request, Family $family): Response
    {
        $reservation = new Reservation();
        $reservation->setFamily($request->get('family'));
        $reservation->setCreche($request->get('creche'));
        $reservation->setChild($request->get('child'));
        $reservation->setCalendar($request->get('calendar'));
        $reservation->setStatus($request->get('status'));

        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('parent_results', ['id' => $this->getUser()->getFamily()->getId()]);
    }*/

    #[Route('/reservations/{id}', name: 'reservations')]
    public function reservations(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        // Récupérer les données du formulaire
        $crecheId = $request->request->get('creche');
        $childId = $request->request->get('child');
        $calendarId = $request->request->get('calendar');
        $status = $request->request->get('status');

        // Vérifier l'existence des entités
        $creche = $entityManager->getRepository(Creche::class)->find($crecheId);
        $child = $entityManager->getRepository(Child::class)->find($childId);
        $calendar = $entityManager->getRepository(Calendar::class)->find($calendarId);

        if (!$creche || !$child || !$calendar) {
            // Gérer le cas où une des entités n'est pas trouvée
            throw $this->createNotFoundException('Certaines entités n\'ont pas été trouvées.');
        }

        // Supposons que vous ayez déjà l'objet Family à partir du contexte de l'utilisateur
        $family = $this->getUser()->getFamily();

        // Créer une nouvelle instance de réservation
        $reservation = new Reservation();
        $reservation->setFamily($family);
        $reservation->setCreche($creche);
        $reservation->setChild($child);
        $reservation->setCalendar($calendar);
        $reservation->setStatus($status);

        try {
            // Enregistrer la réservation dans la base de données
            $entityManager->persist($reservation);
            $entityManager->flush();
        } catch (\Exception $e) {
            // Gérer l'erreur de sauvegarde
            return new Response('Erreur lors de la sauvegarde de la réservation: '
            . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Redirection vers une autre page, par exemple, la page des résultats des parents
        return $this->redirectToRoute('parent_results', ['id' => $family->getId(), 'id_creche' => $creche->getId()]);
    }

    #[Route('/{id}/results/{id_creche}', methods: ['GET', 'POST'], name: 'results')]
    public function showCrecheResults(
        Request $request,
        #[MapEntity(mapping: ['id' => 'id'])] Family $family,
        #[MapEntity(mapping: ['id_creche' => 'id'])] Creche $creche,
        FamilyRepository $familyRepository,
        CrecheRepository $crecheRepository,
        CalendarRepository $calendarRepository,
        ChildRepository $childRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $family = $familyRepository->findOneBy(['id' => $this->getUser()->getFamily()->getId()]);
        $creches = $crecheRepository->findOneBy(['id' => $creche->getId()]);
        $calendar = $calendarRepository->getFreeCalendar($creche);
        $childs = $childRepository->findBy(['family' => $family->getId()]);

        return $this->render('parent/presentation-creche.html.twig', [
            'family' => $family,
            'creches' => $creches,
            'calendar' => $calendar,
            'childs' => $childs,
        ]);
    }
    // Page détail crèche - Parents
    #[Route('/moyens-de-paiement', methods: ['GET'], name: 'checkout')]
    public function checkout(): Response
    {
        return $this->render('parent/moyens-de-paiement.html.twig');
    }
}
