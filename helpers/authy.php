<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php"); // Redireciona para a página de login
        exit();
    }

    // Aqui você pode usar o ID do usuário
    $user_id = $_SESSION['user_id'];
?>