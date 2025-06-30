<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TableaudebordController extends AbstractController
{
    #[Route('/admin/tableaudebord', name: 'admin_tableaudebord')]
    public function index(): Response
    {
        return $this->render('pages/tableaudebord/index.html.twig', [
            'controller_name' => 'TableaudebordController',
        ]);
    }
}
