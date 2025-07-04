<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TemoiniageController extends AbstractController
{
    #[Route('/admin/temoiniage', name: 'admin_temoiniage')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('admin_temoiniage');
        return $this->render('pages/temoiniages/temoiniages.html.twig');
    }

}
