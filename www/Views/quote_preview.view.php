<!-- quote_preview.view.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prévisualisation du Devis</title>
</head>
<body>
    <!-- Affichage du contenu du PDF -->
    <div>
        <?php echo $pdfContent; ?>
    </div>

    <!-- Lien pour télécharger le devis au format PDF -->
    <a href="/generate-quote-pdf" target="_blank">Télécharger le devis au format PDF</a>
</body>
</html>
