<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Cliente</title>
    <link rel="stylesheet" href="/bytecare/css/createClient.css?v=1.0">
</head>
<body>
    <div class="form-container">
        <h2>Criar Novo Cliente</h2>
        <form action="<?= $BASE_URL ?>processClient.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Nome do cliente" required>
            <label for="lastname">LastName:</label>
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" required>
            <label for="age">Age:</label>
            <input type="text" name="age" id="age" placeholder="42" required>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" placeholder="00 00000-0000">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="example@google.com" required>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" placeholder="12345678900" required>
            <label for="street">Street:</label>
            <input type="text" name="street" id="street" placeholder="Street" required>
            <label for="residence_number">Residence Number:</label>
            <input type="text" name="residence_number" id="residence_number" placeholder="123" required>
            <label for="pub_place">Pub Place:</label>
            <input type="text" name="pub_place" id="pub_place" placeholder="Pub Place" required>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" placeholder="City" required>
            <label for="cep">Cep:</label>
            <input type="text" name="cep" id="cep" placeholder="00000-000" required>
            <label for="state">State:</label>
            <input type="text" name="state" id="state" placeholder="State" required>
            <label for="os_historic">OS Historic:</label>
            <input type="text" name="os_historic" id="os_historic" disabled>
            <input type="hidden" name="process" value="create">
            <input type="submit" value="Save">
        </form>
        <a href="<?= $BASE_URL ?>client.php">
            <button class="back-button">Back</button>
        </a>
    </div>
</body>
</html>
<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php'
?>