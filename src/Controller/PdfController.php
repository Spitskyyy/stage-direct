<?php

namespace App\Controller;

use App\Service\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/export-pdf', name: 'export_pdf', methods: ['POST'])]
    public function exportPdf(Request $request, PdfService $pdfService)
    {
        // Récupérer le contenu édité envoyé par TinyMCE
        $content = $request->request->get('content');

        // Ajout d'un template HTML de base pour entourer le contenu
        $html = $this->renderView('pdf/example.html.twig', [
            'content' => $content
        ]);

        // Diffuser le PDF directement au navigateur
        $pdfService->streamPdf($html, 'document.pdf');

        return null; // Pas besoin de retourner une réponse, le PDF est diffusé directement
    }
}
