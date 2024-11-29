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
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Nome do funcionário" required>
            
            <label for="lastname">LastName:</label>
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" required>
            
            <label for="department">Department:</label>
            <select name="department" id="department" required>
                <option value="administrador">Administrador</option>
                <option value="secretaria">Secretaria</option>
                <option value="tecnico">Técnico</option>
            </select>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="********" required>
            
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" placeholder="(51)123456789" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="example@google.com" required>
            
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
