<?php

namespace App\Controller;

use App\Repository\TarifsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TarifsController extends AbstractController
{
    #[Route('/tarifs', name: 'app_tarifs')]
    public function index(
        TarifsRepository $tarifRepository,
        RequestStack $requestStack
    ): Response {
        $locale = $requestStack->getCurrentRequest()->getLocale();

        $blocs = $tarifRepository->findBy(['locale' => $locale]);

        if (!$blocs) {
            $blocs = $tarifRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/tarifs/tarifs.html.twig', [
            'contenus' => $contenus,
            'mode_edition' => false,
            'locale' => $locale,
        ]);
    }
}