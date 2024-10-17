<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/url.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/db.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $department = $_POST['department'];

        // Verifica se os campos estão preenchidos
        if (empty($user) || empty($password) || empty($name) || empty($department)) {
            $error = "Preencha todos os campos.";
        } else {
            // Hash da senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insere o novo usuário no banco de dados
            $stmt = $connect->prepare("INSERT INTO EMPLOYEES (ID_FUN, NAME, PASSWORD, DEPARTMENT) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $user, $name, $hashedPassword, $department);

            if ($stmt->execute()) {
                ?><div class="register-class" align="center"><h4><?php echo "Usuário cadastrado com sucesso!"; ?></h4></div><?php
            } else {
                $error = "Erro ao cadastrar o usuário.";
            }
            
            $stmt->close();
        }
    }

    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="/bytecare/css/cadUser.css?v=1.0">
</head>
<body>
    <div class="register-class" align="center">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h4>Cadastre um novo usuário</h4>
            <div class="buttonUser-class">
                <input type="text" name="user" id="user" placeholder="Usuário" required>
            </div>
            <div class="buttonName-class">
                <input type="text" name="name" id="name" placeholder="Nome" required>
            </div>
            <div class="buttonPassword-class">
                <input type="password" name="password" id="password" placeholder="Senha" required>
            </div>
            <div class="buttonDepartment-class">
                <select name="department" id="department" required>
                    <option value="">Selecione o Departamento</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Secretaria">Secretaria</option>
                    <option value="Técnico">Técnico</option>
                </select>
            </div>
            <div class="submit-class">
                <input type="submit" value="Cadastrar">
            </div>
            <?php
                if (isset($error)) {
                    echo "<div class='error-class'><p style='color: red; margin-top: 10px;'>$error</p></div>";
                }
            ?>
        </form>
    </div>
</body>
</html>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/footer.php';
?>
