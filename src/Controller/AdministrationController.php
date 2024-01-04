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

#[Route('/administration', name: 'administration_')]
class AdministrationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('administration/index.html.twig');
    }
}
