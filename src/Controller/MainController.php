<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(name: 'main_')]
final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/about-us', name: 'about-us')]
    public function aboutUs(): Response {
        return $this->render('main/aboutUs.html.twig');
    }
}
