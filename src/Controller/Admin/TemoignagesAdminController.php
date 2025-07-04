<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TemoignagesAdminController extends AbstractController
{
    #[Route('/temoignages/admin', name: 'app_temoignages_admin')]
    public function index(): Response
    {
        return $this->render('temoignages_admin/index.html.twig', [
            'controller_name' => 'TemoignagesAdminController',
        ]);
    }
}
