<?php 
    session_start();

    $db_host = "localhost";
    $db_name = "bytecare";
    $db_user = "gabs";
    $db_pass = "gabs123";

    // Conexão com o banco de dados
    $connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>