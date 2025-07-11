<?php

namespace App\Controller;

use App\Repository\FaqRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(
        FaqRepository $faqRepository,
        RequestStack $requestStack
    ): Response {
        $locale = $requestStack->getCurrentRequest()->getLocale();

        $blocs = $faqRepository->findBy(['locale' => $locale]);

        if (!$blocs) {
            $blocs = $faqRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/faq/faq.html.twig', [
            'contenus' => $contenus,
            'locale' => $locale,
            'mode_edition' => false, 
        ]);
    }
}