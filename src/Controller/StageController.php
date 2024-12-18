<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use App\Service\PdfService;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/stage')]
#[IsGranted('ROLE_USER')]
final class StageController extends AbstractController
{
    #[Route(name: 'app_stage_index', methods: ['GET'])]
    public function index(Request $request, StageRepository $stageRepository): Response
    {
        $searchTerm = $request->query->get('search', '');
        $sort = $request->query->get('sort', 'id'); // Colonne par défaut : id
        $order = $request->query->get('order', 'asc'); // Ordre par défaut : asc

        // Récupération des stages avec tri et recherche
        $stages = $stageRepository->findBySearchAndSort($searchTerm, $sort, $order);

        return $this->render('stage/index.html.twig', [
            'stage' => $stages,
            'searchTerm' => $searchTerm,
            'sort' => $sort,
            'order' => $order,
        ]);
    }

    #[Route('/new', name: 'app_stage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stage);
            $entityManager->flush();

            $this->addFlash('success', 'Stage créé avec succès.');

            return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stage/new.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_stage_show', methods: ['GET'])]
    public function show(Stage $stage): Response
    {
        return $this->render('stage/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stage $stage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Stage mis à jour avec succès.');

            return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stage/edit.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_stage_delete', methods: ['POST'])]
    public function delete(Request $request, Stage $stage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stage);
            $entityManager->flush();

            $this->addFlash('success', 'Stage supprimé avec succès.');
        }

        return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/stage/export', name: 'app_stage_export', methods: ['GET'])]
public function exportStagesToPdf(StageRepository $stageRepository, PdfService $pdfService): Response
{
    // Récupérer tous les stages depuis la base de données
    $stages = $stageRepository->findAll();

    // Générer le contenu HTML à partir d'un template Twig
    $html = $this->renderView('stage/export.html.twig', [
        'stages' => $stages,
    ]);

    // Générer le PDF
    return new Response(
        $pdfService->generatePdf($html),
        Response::HTTP_OK,
        ['Content-Type' => 'application/pdf']
    );
}
}
