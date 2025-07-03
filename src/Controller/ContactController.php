<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/formulaire', name: 'app_contact')]
    public function index(ContactRepository $contactRepository, RequestStack $requestStack): Response
    {
        // Récupère la locale courante (ex: 'fr', 'en')
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // Recherche les coordonnées pour cette locale
        $contact = $contactRepository->findOneBy(['locale' => $locale]);

        // Si pas trouvé, fallback sur 'fr'
        if (!$contact) {
            $contact = $contactRepository->findOneBy(['locale' => 'fr']);
        }

        return $this->render('pages/formulaire/formulaire.html.twig', [
            'contact' => $contact,
            'mode_edition' => false,
            'locale' => $locale,
        ]);
    }
}