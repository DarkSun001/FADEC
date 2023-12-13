<?php

namespace App\Controllers;

use App\Core\View;

class Devis
{
    private $companyName = "Ma Super Entreprise";

    public function generateQuotePDF(): string
    {
        ob_start();
        // Logique de génération du contenu PDF
        echo "Nom de l'entreprise : " . $this->companyName;
        // ... Autres détails du devis
        return ob_get_clean();
    }

    public function devis_preview(): void
    {
        // Générer le contenu du PDF
        $pdfContent = $this->generateQuotePDF();

        // Afficher la vue de prévisualisation avec le contenu du PDF
        $view = new View("quote_preview", "back", ['pdfContent' => $pdfContent]);
        $view->render('quote_preview', 'back');
    }
}

