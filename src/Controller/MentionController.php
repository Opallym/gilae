<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MentionController extends AbstractController
{
    #[Route('/mention', name: 'app_mention')]
    public function index(): Response
    {
        // Données de l'éditeur du site
        $siteEditor = [
            'name' => 'Gilae consiergerie',
            'title' => 'Consultante en stratégie',
            'address' => '7 avenue La Fontaine Le Boeur',
            'postal_code' => '56100',
            'city' => 'Lorient', 
            'region' => 'Bretagne',
            'siret' => 'Votre numéro SIRET ici',
            'responsible' => 'Gilae consiergerie'
        ];

        // Données de l'hébergeur
        $siteHost = [
            'name' => 'Squarespace',
            'phone' => '+00 00 00 00 00',
            'address' => '000 7nd st, 7 ème, NY'
        ];

        return $this->render('pages/mention/mention.html.twig', [
            'site_editor' => $siteEditor,
            'site_host' => $siteHost
        ]);
    }
}
