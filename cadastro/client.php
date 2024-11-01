<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';

try {
    $stmt = $connect->prepare("SELECT * FROM client");
    $stmt->execute();
    $clients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Erro ao carregar clientes: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Manager</title>
    <link rel="stylesheet" href="/bytecare/css/client.css?v=1.0">
</head>
<body>
    <h1 class="text-center">Gerenciar Clientes</h1>
    <div class="text-center">
        <a href="<?= $BASE_URL ?>createClient.php" class="create-button">
            <button>Criar Cliente</button>
        </a>
    </div>
    <?php if (!empty($clients)) { ?>
        <table class="table" id="clients-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($clients as $client) { ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($client['id']) ?></td>
                        <td><?= htmlspecialchars($client['NAME']) ?></td>
                        <td><?= htmlspecialchars($client['LASTNAME']) ?></td>
                        <td><?= htmlspecialchars($client['PHONE']) ?></td>
                        <td class="actions">
                            <a href="<?= $BASE_URL ?>edit.php?id=<?= htmlspecialchars($client['id']) ?>">
                                <i class="fas fa-edit edit-icon"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <div class="pagination" id="pagination"></div>
        </table>
    <?php } else { ?>
        <p class="empty-list-text">Ainda não há clientes cadastrados! 
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
