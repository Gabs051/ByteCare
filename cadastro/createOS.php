<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';
?>

<link rel="stylesheet" href="/bytecare/css/createOS.css?v=1.0">

<div class="form-container">
    <h2>Criar Nova Ordem de Serviço</h2>
    <form action="<?= $BASE_URL ?>processOS.php" method="post">
        <label for="equipment">Equipamento:</label>
        <input type="text" name="equipment" id="equipment" placeholder="Equipamento" required>
        <label for="description_equipment">Descrição do Produto:</label>
        <input type="text" name="description_equipment" id="description_equipment" placeholder="Descrição do Produto" required>
        <label for="entry_date">Data de Entrada:</label>
        <input type="text" name="entry_date" id="entry_date" placeholder="22/05/24" required>
        <label for="expected_delivery_date">Data prevista para Entrega:</label>
        <input type="text" name="expected_delivery_dat" id="expected_delivery_date" placeholder="07/06/24" required>
        <label for="responsible_tech">Técnico Responsável:</label>
        <input type="responsible_tech" name="responsible_tech" id="responsible_tech" placeholder="Pedro Silva" required>
        <label for="stat_service">Status do Serviço:</label>
        <input type="text" name="stat_service" id="stat_service" placeholder="Em Andamento" required>
        <label for="cust">Custo: R$</label>
        <input type="text" name="cust" id="cust" placeholder="Custo: R$300,00" required>
        <label for="type_service">Tipo de Serviço:</label>
        <input type="text" name="type_service" id="type_servicer" placeholder="Formatação" required>
        <label for="delivery_date">Data de Entrega:</label>
        <input type="text" name="delivery_date" id="delivery_date" placeholder="02/06/24" required>
        <label for="id_client">Id do Cliente:</label>
        <input type="text" name="id_client" id="id_client" placeholder="7" required>
        <label for="id_employee">Id do Funcionário:</label>
        <input type="text" name="id_employee" id="id_employee" placeholder="3" required>
        <input type="hidden" name="process" value="create">
        <input type="submit" value="Save">
    </form>
    </form>
    <a href="<?= $BASE_URL ?>OS.php">
        <button class="back-button">Back</button>
    </a>
</div>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php'
?>