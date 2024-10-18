<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/db.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/url.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_POST['user'];
        $password = $_POST['password'];


        // Verifica se o campo usuário está preenchido
        if (empty($user) || empty($password)) {
            $error = "Preencha todos os campos.";
        } else {
            // Prepara a query para evitar SQL injection
            $stmt = $connect->prepare("SELECT ID, PASSWORD FROM EMPLOYEES WHERE ID = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();

                // Verifica a senha utilizando password_verify
                if (password_verify($password, $userData['PASSWORD'])) {
                    $_SESSION['user_id'] = $userData['ID'];
                    echo "Login realizado com sucesso!";

                    // Redireciona para outra página após login bem-sucedido
                    header('Location: http://26.44.118.123/bytecare/sobre/sobre.php');
                    exit;
                } else {
                    $error = "Senha incorreta.";
                }
            } else {
                $error = "Usuário não encontrado, entre em contato com o administrador.";
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
    <title>Login</title>
    <link rel="stylesheet" href="/bytecare/css/loginStyle.css?v=1.0">
</head>
<body>
    <div class="login-class" align="center">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h4>Faça seu Login</h4>
            <div class="buttonUser-class">
                <input type="text" name="user" id="user" placeholder="Usuário" required>
            </div>
            <div class="buttonPassword-class">
                <input type="password" name="password" id="password" placeholder="Senha" required>
            </div>
            <div class="submit-class">
                <input type="submit" value="Logar">
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
