<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    $id = $_GET['id'];
    if (!is_int($id)) {
        $id = intval($id);
    }

    $stmt = $connect -> prepare("SELECT * FROM service_order WHERE id = ?");
    $stmt -> bind_param("i", $id);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
?>

<link rel="stylesheet" href="/bytecare/css/editOS.css?v=1.0">

<div class="form-container">
    <h2>Editar Ordem de Serviços</h2>
    <form action="<?= $BASE_URL ?>processOS.php" method="post">
        <label for="equipment">Equipamento:</label>
        <input type="text" name="equipment" id="equipment" placeholder="Equipamento" required value="<?= $row['equipment']; ?>">
        <label for="description_equipment">Descrição do Produto:</label>
        <input type="text" name="description_equipment" id="description_equipment" placeholder="Descrição do Produto" required value="<?= $row['description_equipment']; ?>">
        <label for="entry_date">Data de Entrada:</label>
        <input type="text" name="entry_date" id="entry_date" placeholder="22/05/24" required value="<?= $row['entry_date']; ?>">
        <label for="expected_delivery_date">Data prevista para Entrega:</label>
        <input type="text" name="expected_delivery_dat" id="expected_delivery_date" placeholder="07/06/24" required value="<?= $row['expected_delivery_date']; ?>">
        <label for="responsible_tech">Técnico Responsável:</label>
        <input type="responsible_tech" name="responsible_tech" id="responsible_tech" placeholder="Pedro Silva" required value="<?= $row['responsible_tech']; ?>">
        <label for="stat_service">Status do Serviço:</label>
        <input type="text" name="stat_service" id="stat_service" placeholder="Em Andamento" required value="<?= $row['stat_service']; ?>">
        <label for="cust">Custo: R$</label>
        <input type="text" name="cust" id="cust" placeholder="Custo: R$300,00" required value="<?= $row['cust']; ?>">
        <label for="type_service">Tipo de Serviço:</label>
        <input type="text" name="type_service" id="type_servicer" placeholder="Formatação" required value="<?= $row['type_service']; ?>">
        <label for="delivery_date">Data de Entrega:</label>
        <input type="text" name="delivery_date" id="delivery_date" placeholder="02/06/24" required value="<?= $row['delivery_date']; ?>">
        <label for="id_client">Id do Cliente:</label>
        <input type="text" name="id_client" id="id_client" placeholder="7" required value="<?= $row['id_client']; ?>">
        <label for="id_employee">Id do Funcionário:</label>
        <input type="text" name="id_employee" id="id_employee" placeholder="3" required value="<?= $row['id_employee']; ?>">
        <input type="hidden" name="process" value="edit">
        <input type="submit" value="Save">
    </form>
</div>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php'
?>