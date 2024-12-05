<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST['full_name'];
    $birth_date = $_POST['birth_date'];
    $address = $_POST['address'];
    $insurance = $_POST['insurance'];
    $allergies = $_POST['allergies'];

    // Uložení přihlášky
    $stmt = $conn->prepare("INSERT INTO applications (user_id, event_id, additional_info) VALUES (?, ?, ?)");
    $additional_info = json_encode([
        'full_name' => $full_name,
        'birth_date' => $birth_date,
        'address' => $address,
        'insurance' => $insurance,
        'allergies' => $allergies
    ]);
    $stmt->bind_param("iis", $user_id, $event_id, $additional_info);

    if ($stmt->execute()) {
        // Odeslání potvrzovacího e-mailu
        $user = $conn->query("SELECT email FROM users WHERE id = $user_id")->fetch_assoc();
        $event = $conn->query("SELECT * FROM events WHERE id = $event_id")->fetch_assoc();

        $to = $user['email'];
        $subject = "Potvrzení přihlášky na {$event['title']}";
        $message = "Dobrý den,\n\nVaše přihláška na událost '{$event['title']}' byla úspěšně odeslána.\n\n"
                 . "Detaily přihlášky:\n"
                 . "Jméno: $full_name\n"
                 . "Datum narození: $birth_date\n"
                 . "Adresa: $address\n"
                 . "Zdravotní pojišťovna: $insurance\n"
                 . "Alergie: $allergies\n\n"
                 . "Děkujeme za váš zájem.\n\nODADOZ";

        $headers = "From: odadoz@outlook.cz";

        mail($to, $subject, $message, $headers);

        echo "<div class='success-message'>Přihláška byla úspěšně odeslána a e-mail odeslán!</div>";
    } else {
        echo "<div class='error-message'>Chyba při odesílání přihlášky: " . $conn->error . "</div>";
    }
} else {
    $event = $conn->query("SELECT * FROM events WHERE id = $event_id")->fetch_assoc();
    echo "<!DOCTYPE html>
    <html lang='cs'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Přihláška na {$event['title']}</title>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <body>
        <h2>Přihláška na {$event['title']}</h2>
        <form method='POST'>
            <label for='full_name'>Jméno a příjmení:</label>
            <input type='text' id='full_name' name='full_name' required>
            
            <label for='birth_date'>Datum narození:</label>
            <input type='date' id='birth_date' name='birth_date' required>
            
            <label for='address'>Adresa:</label>
            <input type='text' id='address' name='address' required>
            
            <label for='insurance'>Zdravotní pojišťovna:</label>
            <input type='text' id='insurance' name='insurance' required>
            
            <label for='allergies'>Alergie:</label>
            <textarea id='allergies' name='allergies'></textarea>
            
            <button type='submit'>Odeslat přihlášku</button>
        </form>
        <p style='text-align: center;'><a href='category.php?category={$event['category']}'>Zpět na výběr událostí</a></p>
    </body>
    </html>";
}
?>
