<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    $id = $_GET['id'];
    if (!is_int($id)) {
        $id = intval($id);
    }

    $stmt = $connect -> prepare("SELECT * FROM employees WHERE id = ?");
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
    <title>Editar OS</title>
    <link rel="stylesheet" href="/bytecare/css/editEmployee.css?v=1.0">
</head>
<body>
    <div class="form-container">
        <h2>Editar Ordem de Serviço</h2>
        <form action="<?= $BASE_URL?>processEmployee.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Nome do funcionário" required value="<?= $row['NAME']; ?>">

            <label for="lastname">LastName:</label>
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" required value="<?= $row['LASTNAME']; ?>">

            <label for="department">Departamento:</label>
            <select name="department" id="department" required>
                <option value="administrador" <?= $row['DEPARTMENT'] === 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                <option value="secretaria" <?= $row['DEPARTMENT'] === 'secretaria' ? 'selected' : ''; ?>>Secretaria</option>
                <option value="tecnico" <?= $row['DEPARTMENT'] === 'tecnico' ? 'selected' : ''; ?>>Técnico</option>
            </select>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="********" required>

            <label for="phone">Phone:</label>
            <input type="tel" name="phone" id="phone" placeholder="(51)123456789" required value="<?= $row['PHONE']; ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="example@google.com" required value="<?= $row['EMAIL']; ?>">

            <input type="hidden" name="process" value="edit">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <input type="submit" value="Save">
        </form>
        <a href="<?= $BASE_URL ?>employee.php">
            <button class="back-button">Back</button>
        </a>
    </div>
</body>
</html>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php'
?>