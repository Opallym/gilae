<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceLightController extends AbstractController
{
    #[Route('/service/light', name: 'app_service_light')]
    public function index(): Response
    {
        return $this->render('pages/service_light/index.html.twig', [
            'controller_name' => 'ServiceLightController',
        ]);
    }
}
