<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class FormulaireController extends AbstractController
{
    #[Route('/contacter', name: 'contact')]
    public function index(
        Request $request,
        MailerInterface $mailer,
        RequestStack $requestStack
    ): Response {
        // Récupère la locale comme dans ContactController
        $locale = $requestStack->getCurrentRequest()->getLocale();

        // Crée ton formulaire
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', $locale === 'en' ? 'Message sent successfully!' : 'Message envoyé avec succès !');

            return $this->redirectToRoute('contact');
        }

        // Traductions manuelles comme dans ContactController
        $translations = [];
        if ($locale === 'en') {
            $translations = [
                'title' => 'Contact Us',
                'button' => 'Send Message',
                'placeholder_email' => 'Your email address',
                'placeholder_phone' => 'Your phone number',
                'placeholder_body' => 'Your message',
            ];
        } else {
            $translations = [
                'title' => 'Nous contacter',
                'button' => 'Envoyer le message',
                'placeholder_email' => 'Votre adresse email',
                'placeholder_phone' => 'Votre numéro de téléphone',
                'placeholder_body' => 'Votre message',
            ];
        }

        return $this->render('pages/contact/contact.html.twig', [
            'form' => $form->createView(),
            'translations' => $translations,
            'locale' => $locale,
        ]);
    }
}
