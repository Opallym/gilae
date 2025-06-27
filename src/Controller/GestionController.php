<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GestionController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/gestion', name: 'app_gestion')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_gestion');
        return $this->render('pages/gestion/index.html.twig', [
            'controller_name' => 'GestionController',
        ]);
    }
}
