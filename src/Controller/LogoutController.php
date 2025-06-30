<?php

// src/Controller/Security/LogoutController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer l'utilisateur courant
        $user = $this->getUser();
        
        // Déconnexion manuelle (optionnel)
        // $this->container->get('security.token_storage')->setToken(null);
        // $request->getSession()->invalidate();
        
        // Redirection vers la page d'accueil
        return $this->redirectToRoute('app_home');
    }
}