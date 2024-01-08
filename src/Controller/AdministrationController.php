<?php

namespace App\Controller;

use App\Entity\Administration;
use App\Form\AdministrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Flex\Response as FlexResponse;

#[Route('/administration', name: 'administration_')]
class AdministrationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('');
    }

    #[Route('/add', name:'add')]
    public function addAdminFile(Request $request, EntityManagerInterface $entityManager): Response
    {
        //Création d'un nouvel objet administratif
        $administration = new Administration();
        //Ajouter un lien avec le formulaire associé
        $form = $this->createForm(AdministrationType::class, $administration);
        //Récupération de la data issue du HTTP Request
        $form->handleRequest($request);
        //A la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($administration);
            $entityManager->flush();

            $this->addFlash('successAdministration', 'Vos informations ont bien été ajoutées.');

            return $this->redirectToRoute('administration_index');
        }

        $this->addFlash('failAdministration', 'Il y a eu un problème dans la mise en ligne de vos informations.');

        return $this->render('administration/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'aminFile_edit', methods:['GET','POST'])]
    public function editAdminFile(
        Request $request,
        Administration $adminFile,
        EntityManagerInterface $entityManager
    ): Response {
            $form = $this->createForm(AdministrationType::class, $adminFile);
            $form->handleRequest($request);

        if ($form-> isSubmitted() && $form-> isValid()) {
            $entityManager->persist($adminFile);
            $entityManager->flush();

            $this->addFlash('fileSuccess', 'Votre dossier administratif a bien été mis à jour.');

            return $this->redirectToRoute('administration_index');
        }

        $this->addFlash('fileFail', 'Il y a eu un problème dans la modification de votre dossier administratif.');

        return $this->render('AdminFile/edit-file.html.twig', [
            'formEdit' => $form
        ]);
    }

    #[Route('/{id}/profil', methods:['GET'], name:'parent_profil')]
    public function showAdminFile(Administration $adminFile): Response
    {
        return $this->render('parent/parent-profil.html.twig', [
            'adminFile' => $adminFile,
        ]);
    }

    #[Route('/{id}', name: 'administration_delete', methods: ['POST'])]
    public function deleteAdminFile(
        Request $request,
        Administration $adminFile,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $adminFile->getId(), $request->request->get('_token'))) {
            $entityManager->remove($adminFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('family_', [], Response::HTTP_SEE_OTHER);
    }
}
