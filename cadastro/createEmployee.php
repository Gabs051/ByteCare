<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Cliente</title>
    <link rel="stylesheet" href="/bytecare/css/createEmployee.css?v=1.0">
</head>
<body>
    <div class="form-container">
        <h2>Criar Funcionário</h2>
        <form action="<?= $BASE_URL ?>processEmployee.php" method="post">
            <label for="NAME">Name:</label>
            <input type="text" name="name" id="name" placeholder="Nome do funcionário" required>
            
            <label for="LASTNAME">LastName:</label>
            <input type="text" name="LASTNAME" id="LASTNAME" placeholder="Lastname" required>
            
            <label for="DEPARTAMENT">Department:</label>
            <select name="DEPARTAMENT" id="DEPARTAMENT" required>
                <option value="administrador">Administrador</option>
                <option value="secretaria">Secretaria</option>
                <option value="tecnico">Técnico</option>
            </select>

            <label for="PASSWORD">Password:</label>
            <input type="password" name="PASSWORD" id="PASSWORD" placeholder="********" required>
            
            <label for="PHONE">Phone:</label>
            <input type="text" name="PHONE" id="PHONE" placeholder="(51)123456789" required>
            
            <label for="EMAIL">Email:</label>
            <input type="email" name="EMAIL" id="EMAIL" placeholder="example@google.com" required>
            
            <input type="hidden" name="process" value="create">
            <input type="submit" value="Save">
        </form>
        
        <a href="employee.php">
            <button class="back-button">Back</button>
        </a>
    </div>
</body>
</html>
<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php';
?>
