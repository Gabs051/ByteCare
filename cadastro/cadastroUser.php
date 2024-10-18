<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_POST['name'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];

        // Verifica se os campos estão preenchidos
        if (empty($user) || empty($lastname) || empty($password) || empty($email) || empty($phone) || empty($department)) {
            $error = "preencha todos os campos.";
        } else {
        // Hash da senha
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insere o novo usuário no banco de dados
        $stmt = $connect->prepare("INSERT INTO EMPLOYEES (DEPARTMENT, EMAIL, LASTNAME, NAME, PASSWORD, PHONE) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $department, $email, $lastname, $user, $hashedPassword, $phone);
        
        if ($stmt->execute()) {
            ?><div class="register-class" align="center"><h4><?php echo "Usuário cadastrado com sucesso!"; ?></h4></div><?php
        }else { 
            $error = "Erro ao cadastrar o usuário";
        }

        $stmt->close();
    }
}

    mysqli_close($connect);
?>

<head>
    <link rel="stylesheet" href="/bytecare/css/user.css?v=1.0">
</head>
<body>
    <div class="register-class">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h4>Cadastre um novo usuário</h4>
            <div class="buttonName-class">
                <input type="text" name="name" id="name" placeholder="Nome" required>
            </div>
            <div class="buttonLastName-class">
                <input type="text" name="lastname" id="lastname" placeholder="Sobrenome" required>
            </div>
            <div class="buttonEmail">
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="buttonPhone">
                <input type="text" name="phone" id="phone" placeholder="5551900000000" required>
            </div>
            <div class="buttonPassword">
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
        </form>
    </div>
</body>