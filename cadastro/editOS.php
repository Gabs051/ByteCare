<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    // Prepara e executa a primeira consulta
    $stmt_statService = $connect -> prepare("SELECT stat_service FROM stat_service");
    $stmt_statService->execute();
    $resultStatService = $stmt_statService -> get_result();

    // Array para armazenar todos os resultados de stat_service
    $statServices = [];
    while ($rowSS = $resultStatService->fetch_assoc()) {
        $statServices[] = $rowSS;
    }
    $stmt_statService -> free_result(); // Libera o resultado após o uso
    $stmt_statService -> close(); // Fecha a consulta

    // Prepara e executa a segunda consulta
    $stmt_typeService = $connect->prepare("SELECT type_service FROM type_service");
    $stmt_typeService -> execute();
    $resultTypeService = $stmt_typeService -> get_result();

    // Array para armazenar todos os resultados de type_service
    $typeServices = [];
    while ($rowTS = $resultTypeService -> fetch_assoc()) {
        $typeServices[] = $rowTS;
    }
    $stmt_typeService -> free_result(); // Libera o resultado após o uso
    $stmt_typeService-> close(); // Fecha a consulta

    $stmt_idClient = $connect -> prepare("SELECT id, NAME, LASTNAME FROM client");
    $stmt_idClient -> execute();
    $resutlIdClient = $stmt_idClient -> get_result();

    $idClient = [];
    while ($rowIDC = $resutlIdClient -> fetch_assoc()) {
        $idClient[] = $rowIDC;
    }
    $stmt_idClient -> free_result();
    $stmt_idClient -> close();

    $stmt_idEmployee = $connect -> prepare("SELECT * FROM employees WHERE DEPARTMENT = 'tecnico'");
    $stmt_idEmployee -> execute();
    $resultIdEmployee = $stmt_idEmployee -> get_result();

    $idEmployee = [];
    while ($rowIDE = $resultIdEmployee -> fetch_assoc()) {
        $idEmployee[] = $rowIDE;
    }
    $stmt_idEmployee -> free_result();
    $stmt_idEmployee -> close();

    $id = $_GET['id'];
    if (!is_int($id)) {
        $id = intval($id);
    }

    $stmt = $connect -> prepare("SELECT * FROM service_order WHERE id = ?");
    $stmt -> bind_param("i", $id);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $stmt -> close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar OS</title>
    <link rel="stylesheet" href="/bytecare/css/editOS.css?v=1.0">
</head>
<body>
    <div class="form-container">
        <h2>Editar Ordem de Servços</h2>
        <form action="<?= $BASE_URL?>processOS.php" method="post">
            <label for="equipment">Equipamento:</label>
            <input type="text" name="equipment" id="equipment" placeholder="CPU" required value="<?= $row['equipment']; ?>">

            <label for="equipment_description">Descrição do Equipamento:</label>
            <input type="text" name="equipment_description" id="equipment_description" placeholder="Descrição do Equipamento" required value="<?= $row['equipment_description']; ?>">

            <label for="entry_date">Data de Entrada:</label>
            <input type="text" name="entry_date" id="entry_date" placeholder="21/12/2024" required value="<?= $row['entry_date']; ?>">

            <label for="expected_delivery_date">Data prevista de Entrega:</label>
            <input type="text" name="expected_delivery_date" id="expected_delivery_date" placeholder="18/01/2025" required value="<?= $row['expected_delivery_date']; ?>">

            <label for="responsible_tech">Técnico Responsável:</label>
            <input type="text" name="responsible_tech" id="responsible_tech" placeholder="Gabs" required value="<?= $row['responsible_tech']; ?>">

            <label for="stat_service">Status do Serviço:</label>
            <select name="stat_service" id="stat_service" required>
                <?php foreach ($statServices as $stat_service) { ?>
                    <option value="<?= $stat_service['stat_service'] ?>" <?= $stat_service['stat_service'] === $row['stat_service'] ? 'selected' : ''; ?> > <?= $stat_service['stat_service'] ?> </option>
                <?php } ?>
            </select>
            
            <label for="cust">Custo: </label>
            <input type="text" name="cust" id="cust" placeholder="R$150,00" required value="<?= $row['cust']; ?>">

            <label for="type_service">Tipo do Serviço:</label>
            <select name="type_service" id="type_service" required>
            <?php foreach ($typeServices as $type_service) { ?>
                <option value="<?= $type_service['type_service'] ?>" <?= $type_service['type_service'] === $row['type_service'] ? 'selected' : ''; ?> > <?= $type_service['type_service'] ?> </option>
            <?php } ?>
           <select>

            <label for="delivery_date">Data de Entrega:</label>
            <input type="text" name="delivery_date" id="delivery_date" placeholder="16/01/2025" required value="<?= $row['delivery_date']; ?>">

            <label for="id_client">Id do Cliente:</label>
            <select name="id_client" id="id_client" required>
                <?php foreach ($idClient as $id_client) { ?>
                    <option value="<?= $id_client['id'] ?>" <?= $id_client['id'] === $row['id_client'] ? 'selected' : ''; ?> > <?= $id_client['id'] . ": " .  $id_client['NAME'] . " " . $id_client['LASTNAME']?> </option>
                <?php } ?>
            </select>

            <label for="id_employee">Id do Funcionário:</label>
            <select name="id_employee" id="id_employee" required>
                <?php foreach ($idEmployee as $id_employee) { ?>
                    <option value="<?= $id_employee['ID'] ?>" <?= $id_employee['ID'] === $row['id_employee'] ? 'selected' : ''; ?> > <?= $id_employee['ID'] . ": " .  $id_employee['NAME'] . " " . $id_employee['LASTNAME']?> </option>
                <?php } ?>
            </select>

            <input type="hidden" name="process" value="edit">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <input type="submit" value="Save">
        </form>
        <a href="<?= $BASE_URL ?>OS.php">
            <button class="back-button">Back</button>
        </a>
    </div>
</body>
</html>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php'
?>