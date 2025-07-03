<?php

namespace App\Controller\Admin;

use App\Repository\ServiceRepository;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class ServiceAdminController extends AbstractController
{
    #[Route('/admin/service', name: 'admin_service')]
    public function index(ServiceRepository $serviceRepository, Request $request): Response
    {
        $locale = $request->query->get('locale', 'fr');

        $blocs = $serviceRepository->findBy(['locale' => $locale]);
        if (!$blocs) {
            $blocs = $serviceRepository->findBy(['locale' => 'fr']);
        }

        $contenus = [];
        foreach ($blocs as $bloc) {
            $contenus[$bloc->getCle()] = $bloc->getContenu();
        }

        return $this->render('pages/service/index.html.twig', [
            'contenus' => $contenus,
            'mode_edition' => true,
            'locale' => $locale,
        ]);
    }

    #[Route('/admin/service/update', name: 'admin_service_update', methods: ['POST'])]
    public function update(Request $request, ServiceRepository $serviceRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cle'], $data['texte'], $data['locale'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données invalides'], 400);
        }

        $cle = $data['cle'];
        $texte = $data['texte'];
        $locale = $data['locale'];

        $bloc = $serviceRepository->findOneBy(['cle' => $cle, 'locale' => $locale]);
        if (!$bloc) {
            $bloc = new Service();
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