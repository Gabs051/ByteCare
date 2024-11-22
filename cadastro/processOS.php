<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $process = $_POST['process'] ?? '';
        $message = '';

      
            $equipment = isset($_POST['equipment']) ? trim($_POST['equipment']) : '';
            $equipment_description = isset($_POST['equipment_description']) ? trim($_POST['equipment_description']) : '';
            $entry_date = isset($_POST['entry_date']) ? trim($_POST['entry_date']) : '';
            $expected_delivery_date = isset($_POST['expected_delivery_date']) ? trim($_POST['expected_delivery_date']) : '';
            $responsible_tech = isset($_POST['responsible_tech']) ? trim($_POST['responsible_tech']) : '';
            $stat_service = isset($_POST['stat_service']) ? trim($_POST['stat_service']) : '';
            $cust = isset($_POST['cust']) ? trim($_POST['cust']) : '';
            $type_service = isset($_POST['type_service']) ? trim($_POST['type_service']) : '';
            $delivery_date = isset($_POST['delivery_date']) ? trim($_POST['delivery_date']) : '';
            $id_client = isset($_POST['id_client']) ? trim($_POST['id_client']) : '';
            $id_employee = isset($_POST['id_employee']) ? trim($_POST['id_employee']) : '';

            if ($process === 'create') {
                $sql = "INSERT INTO service_order (equipment, equipment_description, entry_date, expected_delivery_date, responsible_tech, stat_service, cust, type_service, delivery_date, id_client, id_employee)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                if ($stmt = $connect -> prepare($sql)) {
                    $stmt -> bind_param("sssssssssss", $equipment, $equipment_description, $entry_date, $expected_delivery_date, $responsible_tech, $stat_service, $cust, $type_service, $delivery_date, $id_client, $id_employee);
                    $stmt -> execute() ? $message = "Cadastro realizado com sucesso!" : $message = "Erro ao realizar o cadastro!";
                    $stmt -> close();
                } else {
                    $message = "Erro ao preparar a consulta!";
                }
            } elseif ($process === 'edit') {
                $id = intval($_POST['id']);
                $sql = "UPDATE service_order SET
                        equipment = ?, equipment_description = ?, entry_date = ?,
                        expected_delivery_date = ?, responsible_tech = ?, stat_service = ?, cust = ?, type_service = ?, delivery_date = ?, id_client = ?, id_employee = ? WHERE ID = ?";

                if ($stmt = $connect -> prepare($sql)) {
                    $stmt -> bind_param("sssssssssssi", $equipment, $equipment_description, $entry_date, $expected_delivery_date, $responsible_tech, $stat_service, $cust, $type_service, $delivery_date, $id_client, $id_employee, $id);
                    $stmt -> execute() ? $message = "Atualização realizada com sucesso!" : $message = "Erro ao atualizar!";
                    $stmt -> close();
                } else {
                    $message = "Erro ao preparar a atualização!";
                }
            }
        
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process</title>
    <link rel="stylesheet" href="/bytecare/css/processOS.css">
</head>
<body>
    <div class="message"><?= $message; ?></div>
    <a href="<?= $BASE_URL ?>OS.php">
        <button class="back-button">Ok</button>
    </a>
</body>
</html>

<?php 
   } else {
        header('Location: ' . $BASE_URL . 'OS.php');
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php';
?>
