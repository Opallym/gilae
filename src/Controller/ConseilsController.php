<?php

namespace App\Controller;

use App\Repository\ConseilRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ConseilsController extends AbstractController
{
    #[Route('/conseils', name: 'app_conseils')]
    public function index(
        ConseilRepository $conseilRepository,
        RequestStack $requestStack
    ): Response {
        // Récupération de la locale courante (fr, en, etc.)
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // Récupère tous les blocs de contenu pour la locale
        $blocs = $conseilRepository->findBy(['locale' => $locale]);

        // Fallback en français si pas de contenu pour la langue
        if (!$blocs) {
            $blocs = $conseilRepository->findBy(['locale' => 'fr']);
        }

        // Transformation clé => contenu
        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/conseils/conseils.html.twig', [
            'contenus' => $contenus,
        ]);
    }
}
