<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(
        AboutRepository $aboutRepository,
        RequestStack $requestStack
    ): Response {
        // Récupère la locale courante
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // Cherche les blocs de contenu pour cette langue
        $blocs = $aboutRepository->findBy(['locale' => $locale]);

        // Fallback si rien trouvé
        if (!$blocs) {
            $blocs = $aboutRepository->findBy(['locale' => 'fr']);
        }

        // Format clé => contenu
        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/about/about.html.twig', [
            'contenus' => $contenus,
        ]);
    }
}
