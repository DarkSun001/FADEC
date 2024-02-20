<h1>Formulaire de devis - FADEC</h1>

<form action="/submit_devis" method="post" onsubmit="updateSignature()">
    <label for="prestation">Type de prestation :</label><br>
    <select id="prestation" name="prestation">
        <option value="construction">Construction</option>
        <option value="rénovation">Rénovation</option>
        <option value="aménagement">Aménagement</option>
        <!-- Ajoutez d'autres options de prestation selon les besoins -->
    </select><br><br>

    <label for="description">Description de la prestation :</label><br>
    <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

    <label for="materiaux">Matériaux nécessaires :</label><br>
    <textarea id="materiaux" name="materiaux" rows="4" cols="50"></textarea><br><br>

    <label for="client">Informations client :</label><br>
    <input type="text" id="client" name="client"><br><br>

    <label for="email">Email client :</label><br>
    <input type="email" id="email" name="email"><br><br>

    <label for="telephone">Téléphone client :</label><br>
    <input type="tel" id="telephone" name="telephone" pattern="\d{2}\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}"><br><br>

    <label for="prix">Prix HT :</label><br>
    <input type="number" id="prix" name="prix"><br><br>

    <label for="tva">TVA :</label><br>
    <input type="number" id="tva" name="tva"><br><br>

    <label for="total">Prix TTC :</label><br>
    <input type="number" id="total" name="total"><br><br>

    <div class="flex-row">
    <input type="hidden" id="signature" name="signature">
        <div class="wrapper">
            <canvas id="signature-pad" width="400" height="200"></canvas>
        </div>
        <div class="clear-btn">
            <button id="clear"><span> Clear </span></button>
        </div>
    </div>
    <input type="submit" value="Envoyer le devis">
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var canvas = document.getElementById("signature-pad");
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(250,250,250)'
    });

    document.getElementById("clear").addEventListener('click', function() {
        signaturePad.clear();
    });

    // Mettre à jour le champ caché avec les données de la signature avant de soumettre le formulaire
    function updateSignature() {
        var signatureData = signaturePad.toDataURL();
        document.getElementById("signature").value = signatureData;
    }
    
</script>