<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class MessagerieController extends AbstractController
{
    #[Route('/admin/messagerie', name: 'admin_messagerie', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $messages = $em->getRepository(Message::class)->findAll();

        return $this->render('pages/messagerie/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/admin/messagerie/archive/{id}', name: 'admin_messageriearchive', methods: ['POST'])]
    public function archive(
        Message $message,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('archive' . $message->getId(), $submittedToken)) {
            $message->setIsRead(true);
            $em->flush();
            $this->addFlash('success', 'Message archivé avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }

        return $this->redirectToRoute('admin_messagerie');
    }
}