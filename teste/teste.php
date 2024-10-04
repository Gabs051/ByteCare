<?php 
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/helpers/url.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost";
    $dbname = "bytecare";
    $usernamedb = "gabs";
    $password = "gabs123";

    $connect = mysqli_connect($servername, $usernamedb, $password, $dbname);

    if(!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function getNextID($connect) {
        $query = "SELECT MAX(ID_FUN) AS max_id FROM EMPLOYEES";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['max_id'] + 1;
    }

    function addUser($connect, $user, $name, $password, $department) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $id = getNextID($connect);
        $stmt = $connect -> prepare("INSERT INTO EMPLOYEES (ID_FUN, NAME, PASSWORD, DEPARTMENT) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssss", $id, $name, $hashedPassword, $department);
        return $stmt -> execute();
    }

    function updateUser($connect, $id, $name, $password, $department) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt -> $connect -> prepare("UPDATE EMPLOYEES SET NAME = ?, PASSWORD = ?, DEPARTMENT = ? WHERE ID_FUN = ?");
        $stmt -> bind_param("ssss", $name, $hashedPassword, $department, $id);
        return $stmt -> execute();
    }

    function deleteUser($connect, $id) {
        $stmt = $connect -> prepare("DELETE FROM EMPLOYEES WHERE ID_FUN = ?");
        $stmt -> bind_param("s", $id);
        return $stmt -> execute();
    }

    function searchUser($connect, $searchTerm) {
        $stmt = $connect -> prepare("SELECT * FROM EMPLOYEES WHERE NAME LIKE ?");
        $likeTerm = "%" . $searchTerm . "%";
        $stmt -> bind_param("s", $likeTerm);
        $stmt -> execute();
        return $stmt -> get_result();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['add'])) {
            $user = $_POST['add'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $department = $_POST['department'];

            if(empty($user) || empty($password) || empty($name) || empty($department)) {
                $error = "Preencha todos os campos.";
            } else {
                if(addUser($connect, $user, $name, $password, $department)) {
                    echo "<div class='register-class' align='center'><h4>Usuário cadastrado com sucesso!</h4></div>";
                } else {
                    $error = "Erro ao cadastrar o usuário.";
                }
            }
        }

        if(isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $department = $_POST['department'];

            if(empty($id) || empty($name) || empty($password) || empty($department)) {
                $error = "Preencha todos os campos.";
            } else {
                if(updateUser($connect, $id, $name, $password, $department)) {
                    echo "<div class='register-class' align='center'><h4>Usuário atualizado com sucesso!</h4></div>";
                } else {
                    $error = "Erro au atualizar o usuário.";
                }
            }
        }

        if(isset($_POST['delete'])) {
            $id = $_POST['id'];

            if(empty($id)) {
                $error = "Informe o ID do usuário a ser deletado.";
            } else {
                if(deleteUser($connect, $id)) {
                    echo "<div class='register-class' align='center'><h4>usuário deletado com sucesso!</h4></div>";
                } else {
                    $error = "Erro ao deletar o usuário.";
                }
            }
        }

        if(isset($_POST['search'])) {
            $searchTerm = $_POST['searchTerm'];
            $result = searchUser($connect, $searchTerm);
        }
    }

    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de usuários</title>
    <link rel="stylesheet" href="/bytecare/css/cadUser.css">
</head>
<body>
    <div class="register-class" align="center">
        <h4>Gerenciar Usuários</h4>
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
            <div class="buttonUser-class">
                <input type="text" name="user" id="user" placeholder="Usuário" required>
            </div>
            <div class="buttonName-class">
                <input type="text" name="name" id="name" placeholder="Nome" required>
            </div>
            <div class="buttonPassword-class">
                <input type="password" name="password" id="password" placeholder="password" required>
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
                <input type="submit" value="Cadastar" name="add">
            </div>
        </form>

        <h4>Atualizar Usuário</h4>
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
            <div class="buttonId-class">
                <input type="text" name="id" id="id" placeholder="ID do Usuário" required>
            </div>
            <div class="buttonName-class">
                <input type="text" name="name" id="name" placeholder="Nome">
            </div>
            <div class="buttonPassword-class">
                <input type="text" name="password" id="password" placeholder="Senha">
            </div>
            <div class="buttonDepartment-class">
                <select name="department" id="department">
                    <option value="">Selecione o Departamento</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Secretaria">Secretaria</option>
                    <option value="Técnico">Técnico</option>
                </select>
            </div>
            <div class="submit-class">
                <input type="submit" value="Atualizar" name="update">
            </div>
        </form>

        <h4>Deletar Usuário</h4>
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
            <div class="buttonId-class">
                <input type="text" name="id" id="id" placeholder="ID do Usuário" required>
            </div>
            <div class="submit-class">
                <input type="submit" name="delete" value="Deletar">
            </div>
        </form>

        <h4>Pesquisar Usuário</h4>
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
            <div class="buttonSearch-class">
                <input type="text" name="searchTerm" id="searchTerm" placeholder="Nome do Usuário">
            </div>
            <div class="submit-class">
                <input type="submit" name="search" value="Pesquisar">
        </div>
        </form>

        <?php 
            if(isset($results)) {
                echo "<h4>Resultados da pesquisa:</h4>";
                while($row = $results -> fetch_assoc()) {
                    echo "<p>ID: " . $row['ID_FUN'] . "| Nome: " . $row['NAME'] . " | Department: " .  "</p>";
                }
            }
        ?>

        <?php 
            if(isset($error)) {
                echo "<div class='error-class'><p style='color: red; margin-top: 10px;'>$error</p></div>";
            }
        ?>

    </div>  
</body>
</html>