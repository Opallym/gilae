<?php

namespace App\Controller;

use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/contacter', name: 'app_contact')]
    public function index(StatisticsService $stats): Response
    {
        $stats->recordVisit('app_contact');
        return $this->render('pages/contact/contact.html.twig');
    }

}
