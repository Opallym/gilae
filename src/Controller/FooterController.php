<?php

namespace App\Controller;

use App\Repository\FooterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FooterController extends AbstractController
{
    public function index(
        FooterRepository $footerRepository,
        RequestStack $requestStack
    ): Response {
        $locale = $requestStack->getCurrentRequest()->getLocale();

        $blocs = $footerRepository->findBy(['locale' => $locale]);

        if (!$blocs) {
            $blocs = $footerRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/footer/footer.html.twig', [
            'contenus' => $contenus,
        ]);
    }
}
