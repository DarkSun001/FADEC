<h1>Formulaire de devis - FADEC</h1>

<form action="/submit_devis" method="post">
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

    <input type="submit" value="Envoyer le devis">
</form>
