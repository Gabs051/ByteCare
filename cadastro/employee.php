<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';

    try {
        $stmt = $connect -> prepare("SELECT * FROM employees");
        $stmt -> execute();
        $employees = $stmt -> get_result() -> fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        echo "Erro ao carregar funcionárois: " . $e -> getMessage();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Funcionários</title>
    <link rel="stylesheet" href="/bytecare/css/employee.css?v=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pZDUcVg6gbh0DLtOhFVJ6aKNWVp0S2ZZ0FsU5JY0wxyQXj1HGfRydkL1kAvk4J7k" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Gerenciar Funcionários</h1>
    <div class="text-center">
        <a href="<?= $BASE_URL ?>createEmployee.php" class="create-button">
            <button>Criar Funcionário</button>
        </a>
    </div>
    <?php if (!empty($employees)) { ?>
        <table class="table" id="clients-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Departamento</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($employees  as $employee) { ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($employee['ID']) ?></td>
                        <td><?= htmlspecialchars($employee['NAME']) ?></td>
                        <td><?= htmlspecialchars($employee['LASTNAME']) ?></td>
                        <td><?= htmlspecialchars($employee['DEPARTMENT']) ?></td>
                        <td><?= htmlspecialchars($employee['EMAIL']) ?></td>
                        <td class="actions">
                            <a href="<?= $BASE_URL?>editEmployee.php?id=<?= htmlspecialchars($employee['ID']) ?>">
                                <i class="fas fa-edit edit-icon"></i>
                            </a>
                            <form action="<?= $BASE_URL?>processEmployee.php" method="post" style="display: inline;" >
                                <input type="hidden" name="id" value="<?= htmlspecialchars($employee['ID']); ?>">
                                <input type="hidden" name="process" value="delete">
                                <button class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')" >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
            </tbody>
            <div class="pagination" id="pagination"></div>
        </table>
        <?php } else { ?>
            <p class="empty-list-text">Ainda não há funcionários cadastrados!
                <a href="<?= $BASE_URL?>createEmployee.php">Clique aqui para adicionar</a>
            </p>
        <?php } ?>
        <script>
            document.addEventListener("DOMContentLoades", function() {
                const rowPerPage = 10;
                const tableBody = document.getElementById("table-body");
                const pagination = document.getElementById("pagination");
                const rows = Array.from(tableBody.querySelectorAll("tr"));
                const totalPages = Math.cell(rows.lenght / rowPerPage);

                function displayPage(page) {
                    tableBody.innerHTML = "";
                    let start = (page - 1) * rowPerPage;
                    let end = start + rowPerPage;
                    let paginatedRows = rows.slice(start, end);

                    paginatedRows.forEach(row => tableBody.appendChild(row));
                    updatePaginationButtons(page);
                }

                function updatePAginationButtons(page){
                    pagination.innerHTML = "";
                    for (let i = 1; i <= totalPages; i++) {
                        let button = document.createElement("button");
                        button.textContent = i;
                        button.className = i === page ? "active" : "";
                        button.onclick = () =>displayPage(i);
                        pagination.appendChild(button); 
                    }
                }
                displayPage(1);

            });
        </script>
</body>
</html>

<?php
include_once $_SERVER ['DOCUMENT_ROOT'] . '/byteCare/templates/footer.php';
?>