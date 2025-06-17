<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FormulaireController extends AbstractController
{
    #[Route('/contact', name: 'app_formulaire')]
    public function index(): Response
    {
        return $this->render('pages/formulaire/formulaire.html.twig');
    }
}
