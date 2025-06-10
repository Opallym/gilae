<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(): Response
    {
        return $this->render('pages/faq/faq.html.twig');
    }

}
