<?php
// Inicia a sessão

// Inicializa a lista de Usuários
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

// Verifica se um cadastro foi criado, editado ou deletado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];
        $nome = $_POST['nome'] ?? '';
        
        if($acao == 'criar') {
            $_SESSION['usuarios'][] = $nome;
        } elseif ($acao == 'editar') {
            $id = $_POST['id'];
            $_SESSION['usuarios'][$id] = $nome;
        } elseif ($acao == 'deletar') {
            $id = $_POST['id'];
            unset($_SESSION['usuarios']['id']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta carset="UTF-8">
    <title>Gerenciar Usuários</title>
    <script>
        function mostrarFormulario(acao, id = null) {
            const form = document.getElementById('formulario');
            const inputNome = document.getElementById('nome');
            const inputId = document.getElementById('id');
            const titulo = document.getElementById('titulo');

            form.style.display = 'block';
            inputId.value = id ? id : '';
            titulo.innerText = acao.charAt(0).toUpperCase() + acao.slice(1) + 'usuarios';
            inputNome.value = id !== null ? document.getElemntById(`usuarios-${id}`).innerText : '';
        }

        function esconderFormulario() {
            document.getElement('formulario').style.display = 'none';

        }
    </script>
    <style>
        #formulario {
            display: none;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Gerenciar Usuários</h1>

    <button onclick="mostarFormulario('criar')">CRIAR</button>
    <button onclick="mostrarFormulario('editar')">EDITAR</button>
    <button onclick="mostarFormulario('deletar')">DELETAR</button>

    <div id="formulario">
        <h2 id="titulo"> </h2>
        <form method="POST">
            <input type="hidden" name="id" id="id">
            <input type="text" name="nome" id="nome" placeholder="Nome do Usuário" required>
            <input type="hidden" name="acao" id="acao">
            <button type="submit" onclick="document.getElementById('acao').value = event.target.innerText.toLowerCase();">Enviar</button>
            <button type="button" onclick="esconder.Formulario()">Voltar</button>  
    </form>
</div>

    <h2>Lista de Usuários</h2>
<ul> <?php foreach ($_SESSION['usarios'] as $id => $usuarios): ?>
        <li id="usuarios-<?php echo $id; ?>"><?php echo htmlspecialchars($usuarios); ?></li>
    <?php endforeach; ?>
</ul>

    </body>

</html>