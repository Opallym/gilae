<?php

namespace App\Controller;

use App\Repository\HomeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        HomeRepository $homeRepository,
        RequestStack $requestStack
    ): Response {
        // Récupération de la locale courante (ex: 'fr', 'en', etc.)
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // Recherche d'un contenu en fonction de la locale
        $contenu = $homeRepository->findOneBy(['locale' => $locale]);

        // Si aucun contenu trouvé pour la langue actuelle, tu peux ajouter un fallback
        if (!$contenu) {
            $contenu = $homeRepository->findOneBy(['locale' => 'fr']);
        }

        return $this->render('pages/home/home.html.twig', [
            'contenu_home' => $contenu,
        ]);
    }
}
