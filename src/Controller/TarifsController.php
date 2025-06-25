<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TarifsController extends AbstractController
{
    #[Route('/tarifs', name: 'app_tarifs')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_tarifs');
        return $this->render('pages/tarifs/tarifs.html.twig');
    }

}
