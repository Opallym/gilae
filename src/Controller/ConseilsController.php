<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ConseilsController extends AbstractController
{
    #[Route('/conseils', name: 'app_conseils')]
    public function index(): Response
    {
        return $this->render('pages/conseils/conseils.html.twig');
    }

}
