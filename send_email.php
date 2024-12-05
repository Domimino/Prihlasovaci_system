<?php
require 'libs/vendor/autoload.php'; // Autoload pro Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$template_id = $_GET['id'];
$template = $conn->query("SELECT * FROM email_templates WHERE id = $template_id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recipients = $conn->query("
        SELECT u.email, a.additional_info 
        FROM applications a
        JOIN users u ON a.user_id = u.id
    ");

    $subject = $template['subject'];
    $body = $template['body'];

    // PHPMailer konfigurace
    $mail = new PHPMailer(true);

    try {
        // Nastavení serveru
        $mail->isSMTP();
        $mail->Host = 'XXXXXX'; // SMTP server pro Outlook
        $mail->SMTPAuth = true; // Povolit SMTP autentizaci
        $mail->SMTPDebug = 2; // Ladění: výstup všech detailů připojení
        $mail->Username = 'chleba@hul.cz'; // e-mail
        $mail->Password = 'XXXXXXXXXX'; // heslo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Typ šifrování
        $mail->Port = 587; // Port pro šifrované připojení

        // Nastavení odesílatele
        $mail->setFrom('chleba@hul.cz', 'Odadoz');

        while ($recipient = $recipients->fetch_assoc()) {
            $to = $recipient['email'];
            
            // Přidání příjemce
            $mail->addAddress($to);

            // Nastavení obsahu e-mailu
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Odeslání e-mailu
            $mail->send();

            // Vymazání příjemce pro další iteraci
            $mail->clearAddresses();
        }

        echo "<div class='success-message'>E-mail byl úspěšně odeslán všem přihlášeným uživatelům!</div>";
    } catch (Exception $e) {
        echo "<div class='error-message'>E-mail nemohl být odeslán. Chyba: {$mail->ErrorInfo}</div>";
    }
} else {
    echo "<!DOCTYPE html>
    <html lang='cs'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Odeslat e-mail</title>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <body>
        <h2>Odeslat e-mail: {$template['name']}</h2>
        <form method='POST'>
            <p><strong>Předmět:</strong> {$template['subject']}</p>
            <p><strong>Obsah zprávy:</strong></p>
            <pre>{$template['body']}</pre>
            <button type='submit'>Odeslat všem přihlášeným</button>
        </form>
        <p><a href='dashboard.php'>Zpět do administrace</a></p>
    </body>
    </html>";
}
?>
