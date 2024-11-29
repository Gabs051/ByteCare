<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/url.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/db.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/authy.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/bytecare/css/style.css?v=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pZDUcVg6gbh0DLtOhFVJ6aKNWVp0S2ZZ0FsU5JY0wxyQXj1HGfRydkL1kAvk4J7k" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".drop > a").on("click", function(e) {
                e.preventDefault();
                $(this).siblings(".dropdown").stop(true, true).slideToggle(300);
                $(".dropdown").not($(this).siblings(".dropdown")).slideUp(300);
            });

            $(document).click(function(event) {
                if (!$(event.target).closest(".drop").length) {
                    $(".dropdown").slideUp(300);
                }
            });
        });
    </script>
    
</head>
<body>
    <header>
        <nav class="nav fixed">
            <ul>
                <li class="drop">
                    <a href="#">Gerenciar</a>
                    <ul class="dropdown">
                        <li><a href="/bytecare/cadastro/client.php">Clientes</a></li>
                        <li><a href="/bytecare/cadastro/createOS.php">O. de Serviço</a></li>
                        <li><a href="/bytecare/cadastro/employee.php">Usuários</a></li>
                    </ul>
                </li>
                <li class="drop">
                    <a href="#">Relatórios</a>
                    <ul class="dropdown">
                        <li><a href="#">Clientes</a></li>
                        <li><a href="/bytecare/cadastro/OS.php">Serviços</a></li>
                    </ul>
                </li>
                <li><a href="/bytecare/sobre/sobre.php">Sobre</a></li>
                <li><a href="/bytecare/helpers/logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>