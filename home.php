<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domovská stránka</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Vyberte kategorii</h2>
    <ul>
        <li><a href="category.php?category=Tábor">Tábory</a></li>
        <li><a href="category.php?category=Zájmový útvar">Zájmové útvary</a></li>
        <li><a href="category.php?category=Akce">Akce</a></li>
    </ul>
    <p style="text-align: center;"><a href="logout.php">Odhlásit se</a></p>
</body>
</html>
