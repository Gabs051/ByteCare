<?php 
    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); // Redireciona para a página de login
        exit();
    }

    // Aqui você pode usar o ID do usuário
    $user_id = $_SESSION['user_id'];
?>