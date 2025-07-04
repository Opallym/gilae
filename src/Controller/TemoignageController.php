<?php

namespace App\Controller;

use App\Repository\TemoignageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TemoignageController extends AbstractController
{
    #[Route('/admin/temoignages/admin', name: 'app_temoignages')]
    public function index(TemoignageRepository $temoignageRepository): Response
    {
        // Récupère uniquement les témoignages approuvés
        $temoignages = $temoignageRepository->findBy(
            ['isApproved' => true],
            ['createdAt' => 'DESC']
        );

        return $this->render('pages/temoignages/temoignages.html.twig', [
            'temoignages' => $temoignages,
        ]);
    }
}