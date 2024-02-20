<?php

// Inclure la configuration de l'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// Vérifier si l'e-mail a été soumis
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Générer un jeton de réinitialisation (vous pouvez utiliser une bibliothèque pour cela)
    $resetToken = generateResetToken();

    // Envoyer l'e-mail de réinitialisation avec le lien contenant le jeton
    $resetLink = "http://example.com/reset_password_form.php?token=$resetToken";
    $emailContent = "Bonjour,\n\nPour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant :\n$resetLink";
    $subject = "Réinitialisation de mot de passe";
    $headers = "From: " . $_ENV['EMAIL_FROM']; // Utiliser l'adresse e-mail configurée dans le fichier .env

    if (mail($email, $subject, $emailContent, $headers)) {
        // L'e-mail a été envoyé avec succès
        echo json_encode(array("message" => "Un e-mail de réinitialisation a été envoyé à votre adresse e-mail."));
    } else {
        // Erreur lors de l'envoi de l'e-mail
        http_response_code(500);
        echo json_encode(array("message" => "Erreur lors de l'envoi de l'e-mail. Veuillez réessayer plus tard."));
    }
} else {
    // Si l'e-mail n'a pas été soumis, renvoyer une erreur
    http_response_code(400);
    echo json_encode(array("message" => "Adresse e-mail manquante."));
}

// Fonction pour générer un jeton de réinitialisation (exemple)
function generateResetToken() {
    return bin2hex(random_bytes(16)); // Génère un jeton aléatoire de 16 octets et le convertit en une chaîne hexadécimale
}
?>
