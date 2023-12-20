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

    #[Route('/connexion', methods: ['GET', 'POST'], name: 'connexion')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    #[Route('/inscription', methods: ['GET', 'POST'], name: 'inscription')]
    public function register(): Response
    {
        return $this->render('register.html.twig');
    }
}
