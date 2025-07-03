<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(
        ServiceRepository $serviceRepository,
        RequestStack $requestStack
    ): Response {
        $locale = $requestStack->getCurrentRequest()->getLocale();

        $blocs = $serviceRepository->findBy(['locale' => $locale]);

        if (!$blocs) {
            $blocs = $serviceRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/service/index.html.twig', [
            'contenus' => $contenus,
            'mode_edition' => false,
            'locale' => $locale,
        ]);
    }
}