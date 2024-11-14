<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    $stmt_statService = $connect->prepare("SELECT stat_service FROM stat_service");
    $stmt_typeService = $connect->prepare("SELECT type_service FROM type_service");

    // Execute a primeira consulta
    $stmt_statService->execute();
    $resultStatService = $stmt_statService->get_result();  // Obtenha o resultado da primeira consulta
    $rowSS = $resultStatService->fetch_assoc();

    // Execute a segunda consulta
    $stmt_typeService->execute();
    $resultTypeService = $stmt_typeService->get_result();  // Obtenha o resultado da segunda consulta
    $rowTS = $resultTypeService->fetch_assoc();

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
    <div class="form-container"></div>
    <h2>Nova Ordem de Serviço</h2>
    <form action="<?= $BASE_URL ?>processServiceOrder.php" method="post">

        <label for="equipment">Equipamento:</label>
        <input type="text" name="equipment" id="equipment" placeholder="Descrição do equipamento" required>

        <input type="text" name="equipment_description" id="equipemnt_description" placeholder>
        <label for="equipment_description">Descrição do Equipamento:</label>
        <textarea name="" id=""></textarea>

        
        

        <label for="stat_service">
            <select name="stat_service" id="stat_service">
                <?php foreach ($rowSS as $stat_service) { ?>
                    <option value="<?= $stat_service ?>"> <?= $stat_service ?></option>
                <?php } ?>
            </select>
        </label>

    </form>      
</div>
</body>
</html> 

