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
    <link rel="stylesheet" href="/bytecare/css/headerStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".drop").hover(
                function() {
                    $(this).find(".dropdown").stop(true, true).slideDown(300); // Mostra o dropdown correspondente
                },
                function() {
                    $(this).find(".dropdown").stop(true, true).slideUp(300);   // Esconde o dropdown correspondente
                }
            );
        });
    </script>
</head>
<body>
    <header>
        <nav class="nav">
            <ul>
                <li class="drop">
                    <a href="http://26.44.118.123/bytecare/cadastro/cadastro.php">Cadastros</a>
                    <ul class="dropdown">
                        <li><a href="#">CAD. DE CLIENTE</a></li>
                        <li><a href="#">CAD. DE OS</a></li>
                        <li><a href="http://26.44.118.123/bytecare/cadastro/cadastroUser.php">CAD. DE USUÁRIOS</a></li>
                    </ul>
                </li>
                <li class="drop">
                    <a href="#">Relatórios</a>
                    <ul class="dropdown">
                        <li><a href="#">CLIENTES</a></li>
                        <li><a href="#">SERVIÇOS</a></li>
                    </ul>
                </li>
                <li><a href="http://26.44.118.123/bytecare/sobre/sobre.php">Sobre</a></li>
                <li><a href="http://26.44.118.123/bytecare/login.php">Sair</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>