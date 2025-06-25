<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ConseilsController extends AbstractController
{
    #[Route('/conseils', name: 'app_conseils')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_conseils');
        return $this->render('pages/conseils/conseils.html.twig');
    }

}
