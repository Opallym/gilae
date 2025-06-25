<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FormulaireController extends AbstractController
{
    #[Route('/contact', name: 'app_formulaire')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_formulaire');
        return $this->render('pages/formulaire/formulaire.html.twig');
    }
}
