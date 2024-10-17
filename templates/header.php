<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/helpers/url.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro</title>
    <!-- LINKS STYLES -->
    <link rel="stylesheet" href="/bytecare/css/headerStyle.css?v=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".drop").on("mouseenter", function() {
                $(this).find(".dropdown").stop(true, true).slideDown(300);
            }).on("mouseleave", function() {
                $(this).find(".dropdown").stop(true, true).slideUp(300);
            });
        });
    </script>
</head>
<body>
    <header>
        <nav class="nav fixed">
            <ul>
                <li class="drop">
                    <a href="http://26.44.118.123/bytecare/cadastro/cadastro.php">Cadastros</a>
                    <ul class="dropdown">
                        <li><a href="#">Cad. de Clientes</a></li>
                        <li><a href="#">Cad. de Os</a></li>
                        <li><a href="http://26.44.118.123/bytecare/cadastro/cadastroUser.php">Cad. de Usuários</a></li>
                    </ul>
                </li>
                <li class="drop">
                    <a href="#">Relatórios</a>
                    <ul class="dropdown">
                        <li><a href="#">Clientes</a></li>
                        <li><a href="#">Serviços</a></li>
                    </ul>
                </li>
                <li><a href="http://26.44.118.123/bytecare/sobre/sobre.php">Sobre</a></li>
                <li><a href="http://26.44.118.123/bytecare/index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
