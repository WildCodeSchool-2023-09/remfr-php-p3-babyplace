<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('website/home.html.twig');
    }

    #[Route('/choix', methods: ['GET', 'POST'], name: 'choix')]
    public function choice(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('choice.html.twig');
    }

    #[Route('/administration', name: 'administration')]
    public function dashboard(): Response
    {
        return $this->render('/dashboard-creche.html.twig');
    }

    #[Route('/results', methods: ['GET'], name:'_results')]
    public function showCrecheResults()
    {
        return $this->render('creche/presentation-creche.html.twig');
    }
}
