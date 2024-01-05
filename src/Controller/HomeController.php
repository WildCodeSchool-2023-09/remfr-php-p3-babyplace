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
        return $this->render('home/index.html.twig');
    }

    #[Route('/inscription', methods: ['GET', 'POST'], name: 'inscription')]
    public function register(): Response
    {
        return $this->render('register.html.twig');
    }

    #[Route('/choix', methods: ['GET', 'POST'], name: 'choix')]
    public function choice(): Response
    {
        return $this->render('choice.html.twig');
    }

    #[Route('/administration', name: 'administration')]
    public function dashboard(): Response
    {
        return $this->render('/dashboard-creche.html.twig');
    }

    /* Website */
    #[Route('/accueil', methods: ['GET', 'POST'], name: 'accueil')]
    public function home(): Response
    {
        return $this->render('website/home.html.twig');
    }
}
