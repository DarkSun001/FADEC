<?php
// Contenu du devis au format HTML
?>
<h1>Devis</h1>
<p>Date: <?php echo date('Y-m-d'); ?></p>
<p>Type de prestation: <?php echo $formData['prestation']; ?></p>
<p>Description de la prestation: <?php echo $formData['description']; ?></p>
<p>Matériaux nécessaires: <?php echo $formData['materiaux']; ?></p>
<p>Informations client: <?php echo $formData['client']; ?></p>
<p>Email client: <?php echo $formData['email']; ?></p>
<p>Téléphone client: <?php echo $formData['telephone']; ?></p>
<p>Prix HT: <?php echo $formData['prix']; ?>€</p>
<p>TVA: <?php echo $formData['tva']; ?>%</p>
<p>Prix TTC: <?php echo $formData['total']; ?> €</p>
<p>Signature:</p>
<img src="<?php echo $formData['signature']; ?>" alt="Signature">