<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ConnexionadminController extends AbstractController
{
    #[Route('/connexionadmin', name: 'app_connexionadmin')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_connexionadmin');
        return $this->render('pages/connexionadmin/index.html.twig', [
            'controller_name' => 'ConnexionadminController',
        ]);
    }
}
