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

    $stmt_idEmployee = $connect -> prepare("SELECT id, NAME, LASTNAME FROM employees WHERE DEPARTMENT = 'tecnico'");
    $stmt_idEmployee -> execute();
    $resultIdEmployee = $stmt_idEmployee -> get_result();

    $idEmployee = [];
    while ($rowIDE = $resultIdEmployee -> fetch_assoc()) {
        $idEmployee[] = $rowIDC;
    }
    $stmt_idEmployee -> free_result();
    $stmt_idEmployee -> close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UFT-8">
    <meta name="viewport" content="wodth=device-width, inital-scale=1.0">
    <title>Cadastro de Ordem de Serviço</title>
    <link rel="stylesheet" href="/bytecare/css/createOS.css?v=1.0">
</head>
<body>
    <div class="form-container">
    <h2>Nova Ordem de Serviço</h2>
    <form action="<?= $BASE_URL ?>processServiceOrder.php" method="post">

        <label for="equipment">Equipamento:</label>
        <input type="text" name="equipment" id="equipment" placeholder="Descrição do Equipamento" required>

        <label for="equipment_description">Descrição do Equipamento:</label>
        <textarea name="equipment_description" id="equipment_description" placeholder="Descreva o problema ou o serviço solicitado"></textarea>

        <label for="entry_date">Data de Entrada:</label>
        <input type="datetime-local" name="entry_date" id="entry_date" required value="<?= date('Y-m-d\TH:i') ?>">

        <label for="expected_delivery_date">Data de Entrega Esperada:</label>
        <input type="datetime-local" name="expected_delivery_date" id="expected_delivery_date">

        <label for="responsible_tech">Técnico Responsável</label>
        <input type="text" name="responsible_tech" id="responsible_tech" placeholder="Nome do técnico">

        <label for="stat_service">Estado de serviço:</label>
        <select name="stat_service" id="stat_service" required>
            <?php foreach ($statServices as $stat_service) { ?>
                <option value="<?= $stat_service['stat_service'] ?>"> <?= $stat_service['stat_service'] ?> </option>
            <?php } ?>
        </select>

        <label for="cust">Custo (R$):</label>
        <input type="number" name="cust" id="cust" placeholder="Ex 100.00" step="0.01">
        
        <label for="type_service">Tipo de Serviço:</label>
        <select name="type_service" id="type_service" required>
            <?php foreach ($typeServices as $type_service) { ?>
                <option value="<?= $type_service['type_service'] ?>"> <?= $type_service['type_service'] ?> </option>
            <?php } ?>
        </select>

        <label for="delivery_date">Data de Entrega:</label>
        <input type="datetime-local" name="delivery_date" id="delivery_date">

        <label for="id_client"> ID do Client: </label>
        <select name="id_client" id="id_client" required>
            <?php foreach ($idClient as $id_client) { ?>
                <option value="<?= $id_client['id'] ?>"> <?= $id_client['id'] . ": " .  $id_client['NAME'] . " " . $id_client['LASTNAME']?> </option>
            <?php } ?>
        </select>

        <label for="id_employee"> ID do Técnico: </label>
        <select name="id_employee" id="id_employee" required>
            <?php foreach ($idEmployee as $id_employee) { ?>
                <option value="<?= $id_employee['id'] ?>"> <?= $id_employee['id'] . ": " .  $id_employee['NAME'] . " " . $id_employee['LASTNAME']?> </option>
            <?php } ?>
        </select>
        <input type="submit" value="Salvar Ordem de Serviço">
    </form>      
    </div>
</body>
</html> 

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php';
?>