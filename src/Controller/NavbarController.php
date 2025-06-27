<?php

namespace App\Controller;

use App\Repository\NavbarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class NavbarController extends AbstractController
{
    #[Route('/navbar', name: 'app_navbar')]
    public function index(
        NavbarRepository $navbarRepository,
        RequestStack $requestStack
    ): Response {
        // Récupération de la locale courante (ex: 'fr', 'en', etc.)
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // Récupère tous les blocs de contenu pour la locale
        $blocs = $navbarRepository->findBy(['locale' => $locale]);

        // Si aucun bloc trouvé pour cette langue, fallback en français
        if (!$blocs) {
            $blocs = $navbarRepository->findBy(['locale' => 'fr']);
        }

        // Transformation en tableau associatif clé => contenu
        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/navbar/navbar.html.twig', [
            'contenus' => $contenus,
        ]);
    }

}
