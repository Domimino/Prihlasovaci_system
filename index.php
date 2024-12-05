<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Přihlášení</h2>
    <form action="login.php" method="POST">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Heslo:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Přihlásit</button>
    </form>
    <p style="text-align: center;">Nemáte účet? <a href="register.php">Registrujte se zde</a>.</p>
</body>
</html>
