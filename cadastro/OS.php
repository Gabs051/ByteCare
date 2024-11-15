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
</head>
<body>
    
</body>
</html>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/footer.php';
?>