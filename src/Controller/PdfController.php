<?php

# src/Controller/PdfController.php
namespace App\Controller;

use App\Service\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/export-pdf', name: 'export_pdf', methods: ['GET'])]
    public function exportPdf(PdfService $pdfService): Response
    {
        // Récupérer les données (par exemple depuis une base de données)
        $data = [
            'title' => 'Export PDF',
            'content' => 'Ceci est un exemple d\'export en PDF avec Symfony et Dompdf.',
        ];

        // Utiliser un fichier Twig pour le contenu HTML
        $html = $this->renderView('pdf/example.html.twig', ['data' => $data]);

        // Générer le PDF
        return new Response(
            $pdfService->generatePdf($html),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
