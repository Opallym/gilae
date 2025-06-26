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

        // Récupère tous les blocs de contenu pour la locale
        $blocs = $homeRepository->findBy(['locale' => $locale]);

        // Si aucun bloc trouvé pour cette langue, fallback en français
        if (!$blocs) {
            $blocs = $homeRepository->findBy(['locale' => 'fr']);
        }

        // Transformation en tableau associatif clé => contenu
        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getKey()] = $bloc->getContenu();
        }

        return $this->render('pages/home/home.html.twig', [
            'contenus' => $contenus,
        ]);
    }
}
