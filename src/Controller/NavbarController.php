<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class NavbarController extends AbstractController
{
    #[Route('/navbar', name: 'app_navbar')]
    public function index(): Response
    {
        return $this->render('pages/navbar/navbar.html.twig');
    }

}
