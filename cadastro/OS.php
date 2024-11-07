<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';

try {
    $stmt = $connect->prepare("SELECT * FROM service_order");
    $stmt->execute();
    $OS = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Erro ao carregar Ordem de Serviços: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OS Manager</title>
    <link rel="stylesheet" href="/bytecare/css/Os.css?v=1.0">
</head>
<body>
    <h1 class="text-center">Gerenciar Ordem de Serviços</h1>
    <div class="text-center">
        <a href="<?= $BASE_URL ?>createOS.php" class="create-button">
            <button>Criar OS</button>
        </a>
    </div>
    <?php if (!empty($OS)) { ?>
        <table class="table" id="OS-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Equipamento</th>
                    <th>Descriçao do Equipamento</th>
                    <th>Data de Entrada</th>
                    <th>Previsão Data de Entrega</th>
                    <th>Técnico Responsável</th>
                    <th>Status do Serviço</th>
                    <th>Custo</th>
                    <th>Tipo de Serviço</th>
                    <th>Data de Saída</th>
                    <th>Id Cliente</th>
                    <th>Id Funcionário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($OS as $service_order) { ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($service_order['id']) ?></td>
                        <td><?= htmlspecialchars($service_order['equipment']) ?></td>
                        <td><?= htmlspecialchars($service_order['equipment_description']) ?></td>
                        <td><?= htmlspecialchars($service_order['entry_date']) ?></td>
                        <td><?= htmlspecialchars($service_order['expected_delivery_date']) ?></td>
                        <td><?= htmlspecialchars($service_order['responsible_tech']) ?></td>
                        <td><?= htmlspecialchars($service_order['stat_service']) ?></td>
                        <td><?= htmlspecialchars($service_order['cust']) ?></td>
                        <td><?= htmlspecialchars($service_order['type_service']) ?></td>
                        <td><?= htmlspecialchars($service_order['delivery_date']) ?></td>
                        <td><?= htmlspecialchars($service_order['id_client']) ?></td>
                        <td><?= htmlspecialchars($service_order['id_employee']) ?></td>
                        <td class="actions">
                            <a href="<?= $BASE_URL ?>editOS.php?id=<?= htmlspecialchars($service_order['id']) ?>">
                                <i class="fas fa-edit edit-icon"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <div class="pagination" id="pagination"></div>
        </table>
    <?php } else { ?>
        <p class="empty-list-text">Ainda não há Ordem de Serviços cadastradas! 
            <a href="<?= $BASE_URL ?>create.php">Clique aqui para adicionar</a>
        </p>
    <?php } ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rowPerPage = 10;
            const tableBody = document.getElementById("table-body");
            const pagination = document.getElementById("pagination");
            const rows = Array.from(tableBody.querySelectorAll("tr"));
            const totalPages = Math.cell(rows.length / rowPerPage);

            function displayPage(page) {
                tableBody.innerHTML = "";
                let start = (page - 1) * rowsPerPage;
                let end = start + rowPerPage;
                let paginatedRows = rows.slice(start, end);

                paginatedRows.forEach(row => tableBody.appendChild(row));
                updatePaginationButtons(page);
            }

            function updatePaginationButtons(page) {
                pagination.innerHTML = "";
                for (let i = 1; i <= totalPages; i++) {
                    let button = document.createElement("button");
                    button.textContent = i;
                    button.className = i === page ? "active" : "";
                    button.onclick = () => displayPage(i);
                    pagination.appendChild(button);
                }
            }

            displayPage(1);
        });
    </script>
</body>
</html>

<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/footer.php';
?>
