<?php
// Připojení k databázi
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kontrola, zda jsou všechna data odeslaná
    if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['product'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $product = $_POST['product'];

        // Vložení dat do tabulky orders
        $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, product) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $product);

        if ($stmt->execute()) {
            $message = "Objednávka byla úspěšně odeslána!";
        } else {
            $message = "Chyba při ukládání objednávky: " . $conn->error;
        }

        $stmt->close();
    } else {
        $message = "Vyplňte prosím všechna pole.";
    }
}

// Zavření připojení k databázi
$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objednávka</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validateForm(event) {
            event.preventDefault();
            const form = document.querySelector("#orderForm");
            const email = form.email.value;
            const name = form.name.value;
            const phone = form.phone.value;

            if (!email || !name || !phone) {
                alert("Vyplňte všechna povinná pole.");
                return;
            }

            if (!/^\S+@\S+\.\S+$/.test(email)) {
                alert("Zadejte platný email.");
                return;
            }

            if (!/^\+?\d{10,15}$/.test(phone)) {
                alert("Zadejte platné telefonní číslo.");
                return;
            }

            form.submit(); // Odeslání formuláře, pokud je vše v pořádku
        }
    </script>
</head>
<body>
    <div class="order-section">
        <h2>Objednejte si náš produkt</h2>
        <?php if (isset($message)) : ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form id="orderForm" method="POST" onsubmit="validateForm(event)">
            <label for="name">Jméno a příjmení:</label>
            <input type="text" id="name" name="name" required placeholder="Vaše jméno a příjmení">
    
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required placeholder="Váš e-mail">
    
            <label for="phone">Telefon:</label>
            <input type="tel" id="phone" name="phone" required placeholder="Váš telefon">
    
            <label for="product">Produkt:</label>
            <select id="product" name="product" required>
                <option value="ebook">E-book</option>
                <option value="guide">Příručka</option>
            </select>
    
            <button type="submit">Odeslat objednávku</button>
        </form>
    </div>
</body>
</html>
