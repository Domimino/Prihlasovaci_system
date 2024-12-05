<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Registrace</h2>
    <form action="register_action.php" method="POST">
        <label for="name">Jméno:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Heslo:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Registrovat</button>
    </form>
    <p style="text-align: center;"><a href="index.php">Zpět na přihlášení</a></p>
</body>
</html>
