<?php

namespace App\Controllers;

use App\Core\View;
use TCPDF;

class Devis
{
    public function showForm(): void
    {
        // Afficher le formulaire
        $view = new View("devis/form_template", "base");
    }

    public function generatePDF(array $formData): void
    {
        if (isset($_POST['signature'])) {
            // Générer le PDF
            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('Devis');
            $pdf->SetSubject('Devis');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();

            // Charger le contenu du modèle HTML
            ob_start();
            include(__DIR__ . '/../Views/Devis/devis_template.view.php');
            $html = ob_get_clean();

            // Ajouter le contenu au PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Générer le fichier PDF
            $pdf->Output('devis.pdf', 'I');
        }else{
            echo "La signature n'est pas définie dans les données du formulaire.";
        }

    }

    public function submitDevis(): void
    {
        // Récupérer les données soumises
        $formData = [
            'prestation' => $_POST['prestation'],
            'description' => $_POST['description'],
            'materiaux' => $_POST['materiaux'],
            'client' => $_POST['client'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'prix' => $_POST['prix'],
            'tva' => $_POST['tva'],
            'total' => $_POST['total'],
            'signature' => $_POST['signature']
        ];

        // Générer le PDF avec les données soumises
        $this->generatePDF($formData);
    }
}
