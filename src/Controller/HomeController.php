<?php

namespace App\Controller;

use App\Repository\HomeRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        HomeRepository $homeRepository,
        RequestStack $requestStack,
        Security $security,
        LogoutUrlGenerator $logoutUrlGenerator
    ): Response {
        // 🔐 Déconnexion automatique si ROLE_ADMIN
        if ($security->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($logoutUrlGenerator->getLogoutPath());
        }

        // 🌐 Locale courante
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // 📦 Récupération des blocs traduits
        $blocs = $homeRepository->findBy(['locale' => $locale]);

        // 🧩 Fallback si aucun bloc pour la locale
        if (!$blocs) {
            
            $blocs = $homeRepository->findBy(['locale' => 'fr']);
        }

        // 🧷 Conversion en tableau clé => contenu
        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getKey()] = $bloc->getContenu();
        }

        // 🎯 Rendu de la page d’accueil
        return $this->render('pages/home/home.html.twig', [
            'contenus' => $contenus,
        ]);
    }
}
