<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $process = $_POST['process'] ?? '';
        $message = '';

        if ($process === 'delete') {
            $id = intval($_POST['id'] ?? 0);
            $sql = "DELETE FROM employees WHERE ID = ?";

            if ($stmt = $connect -> prepare($sql)) {
                $stmt -> bind_param("i", $id);
                if ($stmt -> execute()) {
                    $message = "Funcionário excluído com sucesso!";
                } else {
                    $message = "Erro ao excluir Funcionário!";
                }
                $stmt -> close();
            } else {
                $message = "Erro ao preparar a exclusão!";
            }
        } else {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
            $department = isset($_POST['department']) ? trim($_POST['department']) : '';
            $password = isset($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : ''; // Aplica hash à senha
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';

            if ($process === 'create') {
                $sql = "INSERT INTO employees (NAME, LASTNAME, DEPARTMENT, PASSWORD, EMAIL, PHONE)
                        VALUES (?, ?, ?, ?, ?, ?)";
                
                if ($stmt = $connect -> prepare($sql)) {
                    $stmt -> bind_param("ssssss", $name, $lastname, $department, $password, $email, $phone);
                    $stmt -> execute() ? $message = "Cadastro realizado com sucesso!" : $message = "Erro ao realizar o cadastro!";
                    $stmt -> close();
                } else {
                    $message = "Erro ao preparar a consulta!";
                }
            } elseif ($process === 'edit') {
                $id = intval($_POST['id']);
                $sql = "UPDATE employees SET
                        NAME = ?, LASTNAME = ?, DEPARTMENT = ?,
                        PASSWORD = ?, EMAIL = ?, PHONE = ? WHERE ID = ?";

                if ($stmt = $connect -> prepare($sql)) {
                    $stmt -> bind_param("ssssssi", $name, $lastname, $department, $password, $email, $phone, $id);
                    $stmt -> execute() ? $message = "Atualização realizada com sucesso!" : $message = "Erro ao atualizar!";
                    $stmt -> close();
                } else {
                    $message = "Erro ao preparar a atualização!";
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process</title>
    <link rel="stylesheet" href="/bytecare/css/processEmployee.css">
</head>
<body>
    <div class="message"><?= $message; ?></div>
    <a href="<?= $BASE_URL ?>employee.php">
        <button class="back-button">Ok</button>
    </a>
</body>
</html>

<?php 
    } else {
        header('Location: ' . $BASE_URL . 'employee.php');
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php';
?>
