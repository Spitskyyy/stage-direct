<?php
# src/Service/PdfService.php
namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial'); // Exemple de configuration
        $options->setIsRemoteEnabled(true); // Permet l'utilisation d'images distantes
        
        $this->dompdf = new Dompdf($options);
    }

    public function generatePdf(string $htmlContent): string
    {
        $this->dompdf->loadHtml($htmlContent);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        return $this->dompdf->output();
    }

    public function streamPdf(string $htmlContent, string $filename = 'document.pdf')
    {
        $this->dompdf->loadHtml($htmlContent);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $this->dompdf->stream($filename, [
            'Attachment' => true, // true pour téléchargement, false pour affichage
        ]);
    }
}

