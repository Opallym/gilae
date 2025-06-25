<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_service');
        return $this->render('pages/service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
}