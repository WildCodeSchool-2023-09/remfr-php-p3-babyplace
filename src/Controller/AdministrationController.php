<?php

namespace App\Controller;

use App\Entity\Administration;
use App\Form\AdministrationType;
use App\Entity\Family;
use App\Repository\AdministrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Serializable;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Flex\Response as FlexResponse;

#[Route('/adminfile', name: 'adminfile_')]
class AdministrationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(AdministrationRepository $adminRepository): Response
    {
        return $this->render('AdminFile/index-file.html.twig', [
        'files' => $adminRepository->findAll(),
        ]);
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

            return $this->redirectToRoute('adminfile_index');
        }

        $this->addFlash('failAdministration', 'Il y a eu un problème dans la mise en ligne de vos informations.');

        return $this->render('AdminFile/new-file.html.twig', [
            'formFile' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods:['GET','POST'])]
    public function editAdminFile(
        Request $request,
        Administration $adminFile,
        Family $family,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(AdministrationType::class, $adminFile);
        $form->handleRequest($request);

        if ($form-> isSubmitted() && $form-> isValid()) {
            $entityManager->flush();

            $this->addFlash('fileSuccess', 'Votre dossier administratif a bien été mis à jour.');

            return $this->redirectToRoute('adminfile_edit', ['id' => $family->getId()]);
        }

        $this->addFlash('fileFail', 'Il y a eu un problème dans la modification de votre dossier administratif.');

        return $this->render('AdminFile/edit-file.html.twig', [
            'formFile' => $form
        ]);
    }

    #[Route('/{family_id}/file/{administration_id}', methods:['GET'], name:'')]
    public function showAdminFile(
        #[MapEntity(mapping:['family_id' => 'id'])] Family $parent,
        #[MapEntity(mapping: ['administration_id' => 'id'])] Administration $adminFile
    ): Response {
        return $this->render('adminFile/index-file.html.twig', [
            'parent_id' => $parent,
            'adminFile' => $adminFile,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function deleteAdminFile(
        Request $request,
        Administration $adminFile,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $adminFile->getId(), $request->request->get('_token'))) {
            $entityManager->remove($adminFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adminfile_index', [], Response::HTTP_SEE_OTHER);
    }
}
