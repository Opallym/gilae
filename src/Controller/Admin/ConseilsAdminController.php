<?php

namespace App\Controller\Admin;

use App\Entity\Conseils;
use App\Repository\ConseilsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ConseilsAdminController extends AbstractController
{
    #[Route('/admin/conseils', name: 'admin_conseils')]
    public function index(ConseilsRepository $conseilsRepository, Request $request): Response
    {
         // Récupère la locale courante depuis la query, défaut 'fr'
        $locale = $request->query->get('locale', 'fr');

        $blocs = $conseilsRepository->findBy(['locale' => $locale]);
        if (!$blocs) {
            $blocs = $conseilsRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/conseils/conseils.html.twig', [
            'contenus' => $contenus,
            'mode_edition' => true,
            'locale' => $locale,
        ]);
    }

    #[Route('/admin/conseils/update', name: 'admin_conseils_update', methods: ['POST'])]
    public function update(Request $request, ConseilsRepository $conseilsRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cle'], $data['texte'], $data['locale'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données invalides'], 400);
        }

        $cle = $data['cle'];
        $texte = $data['texte'];
        $locale = $data['locale'];

        $bloc = $conseilsRepository->findOneBy(['cle' => $cle, 'locale' => $locale]);
        if (!$bloc) {
            $bloc = new Conseils();
            $bloc->setCle($cle);
            $bloc->setLocale($locale);
            $em->persist($bloc);
        }

        $bloc->setContenu($texte);

        try {
            $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur lors de la sauvegarde'], 500);
        }

        return new JsonResponse(['success' => true]);
    }
}