<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $process = $_POST['process'] ?? '';
    $message = ''; // Inicializa a mensagem

    // Verifica se a operação é de exclusão
    if ($process === 'delete') {
        $id = intval($_POST['id'] ?? 0); // Obtém o ID, se não houver, assume 0
        $sql = "DELETE FROM client WHERE ID = ?";

        if ($stmt = $connect->prepare($sql)) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Cliente excluído com sucesso!";
            } else {
                $message = "Erro ao excluir cliente!";
            }
            $stmt->close();
        } else {
            $message = "Erro ao preparar a exclusão!";
        }
    } else {
        // Para operações de criação e edição, realiza o trim apenas se necessário
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $age = isset($_POST['age']) ? trim($_POST['age']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
        $street = isset($_POST['street']) ? trim($_POST['street']) : '';
        $residence_number = isset($_POST['residence_number']) ? trim($_POST['residence_number']) : '';
        $pub_place = isset($_POST['pub_place']) ? trim($_POST['pub_place']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $cep = isset($_POST['cep']) ? trim($_POST['cep']) : '';
        $state = isset($_POST['state']) ? trim($_POST['state']) : '';

        if ($process === 'create') {
            $sql = "INSERT INTO client (NAME, LASTNAME, PHONE, EMAIL, CPF, STREET, RESIDENCE_NUMBER, PUB_PLACE, CITY, CEP, STATE, AGE)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $connect->prepare($sql)) {
                $stmt->bind_param("ssssssssssss", $name, $lastname, $phone, $email, $cpf, $street, $residence_number, $pub_place, $city, $cep, $state, $age);
                $stmt->execute() ? $message = "Cadastro realizado com sucesso!" : $message = "Erro ao realizar o cadastro!";
                $stmt->close();
            } else {
                $message = "Erro ao preparar a consulta!";
            }
        } elseif ($process === 'edit') {
            $id = intval($_POST['id']);
            $sql = "UPDATE client SET
                    NAME = ?, LASTNAME = ?, PHONE = ?,
                    EMAIL = ?, CPF = ?, STREET = ?,
                    RESIDENCE_NUMBER = ?, PUB_PLACE = ?, CITY = ?,
                    CEP = ?, STATE = ?, AGE = ? WHERE ID = ?";

            if ($stmt = $connect->prepare($sql)) {
                $stmt->bind_param("ssssssssssssi", $name, $lastname, $phone, $email, $cpf, $street, $residence_number, $pub_place, $city, $cep, $state, $age, $id);
                $stmt->execute() ? $message = "Atualização realizada com sucesso!" : $message = "Erro ao atualizar!";
                $stmt->close();
            } else {
                $message = "Erro ao preparar a consulta!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process</title>
    <link rel="stylesheet" href="/bytecare/css/processClient.css?v=1.0">
</head>
<body>
    <div class="message"><?= $message; ?></div>
    <a href="<?= $BASE_URL ?>client.php">
        <button class="back-button">Ok</button>
    </a>
</body>
</html>

<?php
} else {
    header("Location: client.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php';
?>
