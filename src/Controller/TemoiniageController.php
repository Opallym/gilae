<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TemoiniageController extends AbstractController
{
    #[Route('/temoiniage', name: 'app_temoiniage')]
    public function index(): Response
    {
        return $this->render('pages/temoiniage/temoiniage.html.twig');
    }

}
