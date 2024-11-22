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
            <input type="text" name="equipamento" id="equipment" placeholder="CPU" required value="<?= $row['equipment']; ?>">

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
                <option value="Aguardando Aprovação" <?= $row['stat_service'] === 'Aguardando Aprovação' ? 'selected' : ''; ?>>Aguardando Aprovação</option>
                <option value="Aguardando Peça" <?= $row['stat_service'] === 'Aguardando Peça' ? 'selected' : ''; ?>>Aguardando Peça</option>
                <option value="Em andamento" <?= $row['stat_service'] === 'Em andamento' ? 'selected' : ''; ?>>Em andamento</option>
                <option value="Aguardando Retirada" <?= $row['stat_service'] === 'Aguardando Retirada' ? 'selected' : ''; ?>>Aguardando Retirada</option>
                <option value="Concluído" <?= $row['stat_service'] === 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                <option value="Cancelado" <?= $row['stat_service'] === 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                <option value="Aguardando orçamento" <?= $row['stat_service'] === 'Aguardando orçamento' ? 'selected' : ''; ?>>Aguardando orçamento</option>
                <option value="Não Aprovado" <?= $row['stat_service'] === 'Não Aprovado' ? 'selected' : ''; ?>>Não Aprovado</option>
                <option value="Garantia" <?= $row['stat_service'] === 'Garantia' ? 'selected' : ''; ?>>Garantia</option>
                <option value="Não Aprovado" <?= $row['stat_service'] === 'Não Aprovado' ? 'selected' : ''; ?>>Não Aprovado</option>
            </select>
            
            <label for="cust">Custo: </label>
            <input type="text" name="cust" id="cust" placeholder="R$150,00" requiredvalue="<?= $row['cust']; ?>">

            <label for="type_service">Tipo do Serviço:</label>
            <select name="type_service" id="type_service" required>
                <option value="Formatação" <?= $row['type_service'] === 'Formatação' ? 'selected' : ''; ?>>Formatação</option>
                <option value="Limpeza" <?= $row['type_service'] === 'Limpeza' ? 'selected' : ''; ?>>Limpeza</option>
                <option value="Instalação" <?= $row['type_service'] === 'Instalação' ? 'selected' : ''; ?>>Instalação</option>
                <option value="Suporte" <?= $row['type_service'] === 'Suporte' ? 'selected' : ''; ?>>Suporte</option>
                <option value="Reposição de peça" <?= $row['type_service'] === 'Reposição de peça' ? 'selected' : ''; ?>>Reposição de peça</option>
                <option value="Manutenção" <?= $row['type_service'] === 'Manutenção' ? 'selected' : ''; ?>>Manutenção</option>
                <option value="Outros" <?= $row['type_service'] === 'Outros' ? 'selected' : ''; ?>>Outros</option>
           <select>


            <label for="delivery_date">Data de Entrega:</label>
            <input type="text" name="delivery_date" id="delivery_date" placeholder="16/01/2025" required value="<?= $row['delivery_date']; ?>">

            <label for="id_client">Id do Cliente:</label>
            <input type="text" name="id_client" id="id_client" placeholder="2" required value="<?= $row['id_employee']; ?>">

            <label for="id_employee">Id do Funcionário:</label>
            <input type="text" name="id_employee" id="id_employee" placeholder="1" required value="<?= $row['id_client']; ?>">

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