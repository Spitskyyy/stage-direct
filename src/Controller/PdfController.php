<?php
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends AbstractController
{
    public function generatePdf(): Response
    {
        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Charger le contenu HTML
        $html = $this->renderView('pdf_template.html.twig', [
            'data' => 'Ceci est un exemple de PDF généré avec Symfony !',
        ]);

        // Générer le PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Retourner le PDF comme réponse
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }
}
