<?php

namespace App\Controller;

use App\Service\PdfService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TextController extends AbstractController
{
    #[Route('/text', name: 'app_text')]
    public function index(): Response
    {
        return $this->render('text/index.html.twig', [
            'controller_name' => 'TextController',
        ]);
    }
    

// Route pour exporter le contenu TinyMCE en PDF
#[Route('/tiny/export', name: 'app_tiny_export', methods: ['POST'])]
public function exportTinyToPdf(Request $request, PdfService $pdfService): Response
{
    // Récupérer le contenu édité envoyé via le formulaire (TinyMCE)
    $content = $request->request->get('content');

    if (!$content) {
        return new Response('Aucun contenu fourni', Response::HTTP_BAD_REQUEST);
    }

    // Créer le contenu HTML basé sur un template Twig
    $html = $this->renderView('tiny/export.html.twig', [
        'content' => $content,
    ]);

    // Générer et retourner le PDF
    return new Response(
        $pdfService->generatePdf($html),
        Response::HTTP_OK,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="tiny-content.pdf"',
        ]
    );
}

}
