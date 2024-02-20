<?php

require_once __DIR__ . '/../library/get-database-connection.php';
require_once __DIR__ . '/../library/functions/genId.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $conn;
    private $genId;
    public $id;
    public $recipient;
    public $subject;
    public $message;


    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->genId = new GenId();
    }


    public function send()
    {


        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();


        //recuperation des variable du .env
        $mailHost = $_ENV['MAIL_HOST'];
        $mailUsername = $_ENV['MAIL_USERNAME'];
        $mailPassword = $_ENV['MAIL_PASSWORD'];
        $mailPort = 587;

        
        


        // Utilisation de PHPMailer pour envoyer l'e-mail
        $mail = new PHPMailer(true);

        try {
            // Paramètres du serveur SMTP (à adapter selon votre configuration)
            $mail->isSMTP();
            $mail->Host       = $mailHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $mailUsername;
            $mail->Password   = $mailPassword;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $mailPort;

            // Paramètres de l'e-mail
            $mail->setFrom('crusher94500@gmail.com', 'Crusher');
            $mail->addAddress($this->recipient);
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->message;

            // Envoyer l'e-mail
            if ($mail->send()) {
                // Générer un identifiant aléatoire
                $this->id = $this->genId->generateRandomId();

                // Enregistrez les détails de l'e-mail envoyé dans la base de données si nécessaire
                $query = "INSERT INTO mail (id, recipient, subject, message) 
                    VALUES (:id, :recipient, :subject, :message)";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(":id", $this->id);
                $stmt->bindParam(":recipient", $this->recipient);
                $stmt->bindParam(":subject", $this->subject);
                $stmt->bindParam(":message", $this->message);

                $stmt->execute();

                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
