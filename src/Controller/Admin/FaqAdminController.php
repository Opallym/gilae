<?php

namespace App\Controller\Admin;

use App\Entity\Faq;
use App\Repository\FaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class FaqAdminController extends AbstractController
{
    #[Route('/admin/faq', name: 'admin_faq')]
    public function index(FaqRepository $faqRepository, Request $request): Response
    {
        $locale = $request->query->get('locale', 'fr');

        $faqs = $faqRepository->findBy(['locale' => $locale]);

        $contenus = [];
        foreach ($faqs as $faq) {
            $contenus[$faq->getCle()] = $faq->getContenu();
        }

        return $this->render('pages/faq/faq.html.twig', [
            'contenus' => $contenus,
            'locale' => $locale,
            'mode_edition' => true,
        ]);
    }

    #[Route('/admin/faq/update', name: 'admin_faq_update', methods: ['POST'])]
    public function update(Request $request, FaqRepository $faqRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cle'], $data['texte'], $data['locale'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données manquantes'], 400);
        }

        $cle = $data['cle'];
        $texte = $data['texte'];
        $locale = $data['locale'];

        $faq = $faqRepository->findOneBy(['cle' => $cle, 'locale' => $locale]);

        if (!$faq) {
            $faq = new Faq();
            $faq->setCle($cle);
            $faq->setLocale($locale);
            $em->persist($faq);
        }

        $faq->setContenu($texte);

        try {
            $em->flush();
            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur lors de la sauvegarde'], 500);
        }
    }
}