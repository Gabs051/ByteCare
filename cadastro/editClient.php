<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    $id = $_GET['id'];
    if (!is_int($id)) {
        $id = intval($id);
    }

    $stmt = $connect -> prepare("SELECT * FROM client WHERE id = ?");
    $stmt -> bind_param("i", $id);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="/bytecare/css/editClient.css?v=1.0">
</head>
<body>
    <div class="form-container">
        <h2>Editar Cliente</h2>
        <form action="<?= $BASE_URL ?>processClient.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Nome do cliente" required value="<?= $row['NAME']; ?>">
            <label for="lastname">Lastname:</label>
            <input type="text" name="lastname" id="lastname" placeholder="Sobrenome do cliente" required value="<?= $row['LASTNAME']; ?>">
            <label for="age">Age:</label>
            <input type="text" name="age" id="age" placeholder="42" required value="<?= $row['AGE']; ?>">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" placeholder="00 00000-0000" required value="<?= $row['PHONE']; ?>">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="example@google.com" required value="<?= $row['EMAIL']; ?>">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" placeholder="12345678900" required value="<?= $row['CPF']; ?>">
            <label for="street">Street:</label>
            <input type="text" name="street" id="street" placeholder="Street" required value="<?= $row['STREET']; ?>">
            <label for="residence_number">Residence Number:</label>
            <input type="text" name="residence_number" id="residence_number" placeholder="123" required value="<?= $row['RESIDENCE_NUMBER']; ?>">
            <label for="pub_place">Pub Place:</label>
            <input type="text" name="pub_place" id="pub_place" placeholder="Pub Place" required value="<?= $row['PUB_PLACE']; ?>">
            <label for="city">City:</label>
            <input type="text" name="city" id="city" placeholder="City" required value="<?= $row['CITY']; ?>">
            <label for="cep">Cep:</label>
            <input type="text" name="cep" id="cep" placeholder="00000-000" required value="<?= $row['CEP']; ?>">
            <label for="state">State:</label>
            <input type="text" name="state" id="state" placeholder="State" required value="<?= $row['STATE']; ?>">
            <label for="os_historic">OS Historic:</label>
            <input type="text" name="os_historic" id="os_historic" disabled>
            <input type="hidden" name="process" value="edit">
            <input type="hidden" name="id" value="<?= $id; ?>">
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