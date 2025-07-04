<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MessagerieController extends AbstractController
{
    #[Route('/admin/messagerie', name: 'admin_messagerie')]
    public function index(): Response
    {
        return $this->render('pages/messagerie/index.html.twig', [
            'controller_name' => 'MessagerieController',
        ]);
    }
}
