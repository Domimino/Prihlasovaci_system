<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$category = $_GET['category'];
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2><?php echo $category; ?></h2>
    <ul>
    <?php
    $stmt = $conn->prepare("SELECT * FROM events WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($event = $result->fetch_assoc()) {
        echo "<li>{$event['title']} - {$event['date']} - Cena: {$event['price']} Kč 
              <a href='register_event.php?event_id={$event['id']}'>Přihlásit se</a></li>";
    }
    ?>
    </ul>
    <p style="text-align: center;"><a href="home.php">Zpět na výběr kategorií</a></p>
</body>
</html>
