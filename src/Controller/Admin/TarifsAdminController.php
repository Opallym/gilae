<?php

namespace App\Controller\Admin;

use App\Entity\Tarifs;
use App\Repository\TarifsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class TarifsAdminController extends AbstractController
{
    #[Route('/admin/tarifs', name: 'admin_tarifs')]
    public function index(TarifsRepository $tarifRepository, Request $request): Response
    {
        $locale = $request->query->get('locale', 'fr');
        $blocs = $tarifRepository->findBy(['locale' => $locale]);

        if (!$blocs) {
            $blocs = $tarifRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/tarifs/tarifs.html.twig', [
            'contenus' => $contenus,
            'mode_edition' => true,
            'locale' => $locale,
        ]);
    }

    #[Route('/admin/tarifs/update', name: 'admin_tarifs_update', methods: ['POST'])]
    public function update(Request $request, TarifsRepository $tarifRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cle'], $data['texte'], $data['locale'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données invalides'], 400);
        }

        $cle = $data['cle'];
        $texte = $data['texte'];
        $locale = $data['locale'];

        $bloc = $tarifRepository->findOneBy(['cle' => $cle, 'locale' => $locale]);
        if (!$bloc) {
            $bloc = new Tarifs();
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