<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TarifLightController extends AbstractController
{
    #[Route('/tarif/light', name: 'app_tarif_light')]
    public function index(): Response
    {
        return $this->render('pages/tarif_light/index.html.twig', [
            'controller_name' => 'TarifLightController',
        ]);
    }
}
