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
        $locale = $requestStack->getCurrentRequest()->getLocale();

        $contact = $contactRepository->findOneBy(['locale' => $locale]);
        if (!$contact) {
            $contact = $contactRepository->findOneBy(['locale' => 'fr']);
        }

        $translations = [];
        if ($locale === 'en') {
            $translations = [
                'titrecontact' => 'Contact',
                'bouttoncon' => 'Contact Us',
            ];
        } else {
            $translations = [
                'titrecontact' => 'Contacts',
                'bouttoncon' => 'Nous contacter',
            ];
        }

        return $this->render('pages/formulaire/formulaire.html.twig', [
            'contact' => $contact,
            'mode_edition' => false,
            'locale' => $locale,
            'translations' => $translations,
        ]);
    }
}
