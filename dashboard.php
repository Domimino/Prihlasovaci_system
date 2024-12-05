<?php
include 'db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrační panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Administrační panel</h2>

    <h3>Přihlášky</h3>
    <table>
        <tr>
            <th>Jméno</th>
            <th>Událost</th>
            <th>Další informace</th>
            <th>Stav</th>
            <th>Akce</th>
        </tr>
        <?php
        $result = $conn->query("
            SELECT a.id, u.name AS user_name, e.title AS event_title, a.additional_info, a.status 
            FROM applications a
            JOIN users u ON a.user_id = u.id
            JOIN events e ON a.event_id = e.id
        ");

        while ($row = $result->fetch_assoc()) {
            $info = json_decode($row['additional_info'], true); // Dekódování JSON
            echo "<tr>
                <td>{$row['user_name']}</td>
                <td>{$row['event_title']}</td>
                <td>";

            if ($info) {
                // Kontrola klíčů v JSON
                echo "Jméno: " . ($info['full_name'] ?? 'Neuvedeno') . "<br>";
                echo "Datum narození: " . ($info['birth_date'] ?? 'Neuvedeno') . "<br>";
                echo "Adresa: " . ($info['address'] ?? 'Neuvedeno') . "<br>";
                echo "Zdravotní pojišťovna: " . ($info['insurance'] ?? 'Neuvedeno') . "<br>";
                echo "Alergie: " . ($info['allergies'] ?? 'Neuvedeno') . "<br>";
            } else {
                echo "Žádné další informace.";
            }

            echo "</td>
                <td>{$row['status']}</td>
                <td>
                    <a href='approve_application.php?id={$row['id']}'>Schválit</a> | 
                    <a href='reject_application.php?id={$row['id']}'>Zamítnout</a>
                </td>
            </tr>";
        }
        ?>
    </table>

    <h3>Emailové šablony</h3>
    <ul>
        <?php
        $templates = $conn->query("SELECT * FROM email_templates");

        while ($template = $templates->fetch_assoc()) {
            echo "<li>{$template['name']} 
                <a href='edit_template.php?id={$template['id']}'>Upravit</a> | 
                <a href='send_email.php?id={$template['id']}'>Odeslat</a>
            </li>";
        }
        ?>
    </ul>
</body>
</html>
