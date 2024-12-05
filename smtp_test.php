<?php
require 'libs/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.seznam.cz'; // SMTP server pro Seznam
    $mail->SMTPAuth = true;
    $mail->Username = 'dompa739@seznam.cz'; // Váš Seznam e-mail
    $mail->Password = 'uzumymw123'; // Heslo k e-mailu
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Šifrování SSL
    $mail->Port = 465; // Port pro SSL šifrování

    $mail->setFrom('dompa739@seznam.cz', 'Odadoz Admin'); // Odesílatel
    $mail->addAddress('dominik.pospisil@outlook.cz'); // Příjemce
    $mail->Subject = 'Testovací e-mail';
    $mail->Body = 'Toto je testovací e-mail odeslaný pomocí Seznam.cz SMTP.';

    $mail->send();
    echo "E-mail byl úspěšně odeslán!";
} catch (Exception $e) {
    echo "E-mail nemohl být odeslán. Chyba: {$mail->ErrorInfo}";
}
?>
