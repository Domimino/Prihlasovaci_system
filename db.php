<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'prihlasovani';

// Připojení k databázi
$conn = new mysqli($host, $user, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba při připojení k databázi: " . $conn->connect_error);
}
?>
