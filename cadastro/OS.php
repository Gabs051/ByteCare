<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';

    try {
        $stmt = $connect -> prepare("SELECT * FROM service_order");
        $stmt -> execute();
        $serviceOrder = $stmt -> get_result() -> fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        echo "Erro ao carregar ordens de serviços: " . $e -> getMessage();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OS</title>
    <link rel="stylesheet" href="/bytecare/css/OS.css?v=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pZDUcVg6gbh0DLtOhFVJ6aKNWVp0S2ZZ0FsU5JY0wxyQXj1HGfRydkL1kAvk4J7k" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <h1 class="text-center">Gerenciar O. S.</h1>
    <div class="text-center">
        <a href="<?= $BASE_URL ?>createOS.php" class="create-button">
            <button>Criar OS</button>
        </a>
    </div>
    <?php if (!empty($serviceOrder)) { ?>
        <table class="table" id="os-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Equipamento</th>
                    <th>Data de Registro</th>
                    <th>Status</th>
                    <th>Data Prevista</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($serviceOrder as $service_Order) {?>
                    <tr>
                        <td class="col-id"> <?= htmlspecialchars($service_Order['id']); ?> </td>
                        <td> <?= htmlspecialchars($service_Order['equipment']); ?> </td>
                        <td> <?= htmlspecialchars($service_Order['entry_date']); ?> </td>
                        <td> <?= htmlspecialchars($service_Order['stat_service']); ?></td>
                        <td> <?= htmlspecialchars($service_Order['delivery_date']) ?> </td>
                        <td class="action">
                            <a href="<?= $BASE_URL?>editOS.php?id=<?= htmlspecialchars($service_Order['id'])?>">
                                <i class="fas fa-edit edit-icon"></i>
                            </a>
                            <a href="<?= $BASE_URL?>viewOS.php?id=<?= htmlspecialchars($service_Order['id'])?>">
                                <i class="fas fa-eye view-icon"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
            </tbody>
            <div class="pagination" id="pagination"></div>
        </table>
        <?php } else { ?>
            <p class="empty-list-text">Ainda não há Ordens de serviços cadastradas!
                <a href="<?= $BASE_URL ?>createOS.php">Clique aqui para adicionar</a>
            </p>
        <?php } ?>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
            const rowPerPage = 10;
            const tableBody = document.getElementById("table-body");
            const pagination = document.getElementById("pagination");
            const rows = Array.from(tableBody.querySelectorAll("tr"));
            const totalPages = Math.ceil(rows.length / rowPerPage);

            function displayPage(page) {
                tableBody.innerHTML = "";
                let start = (page - 1) * rowPerPage;
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