<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Šifrování hesla

    // Přidání uživatele do databáze
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "Registrace úspěšná. <a href='index.php'>Přihlaste se</a>.";
    } else {
        echo "Chyba při registraci: " . $conn->error;
    }
}
?>
