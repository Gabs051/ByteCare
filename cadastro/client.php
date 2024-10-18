<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/header.php';

$name = $_POST['name'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$street = $_POST['street'] ?? '';
$home_number = $_POST['home_number'] ?? '';
$pub_place = $_POST['pub_place'] ?? '';
$city = $_POST['city'] ?? '';
$cep = $_POST['cep'] ?? '';
$state = $_POST['state'] ?? '';
$os_historic = $_POST['os_historic'] ?? '';
$age = $_POST['age'] ?? '';

if (isset($_POST['create'])) {
    $stmt = $connect->prepare("INSERT INTO client (
        name, 
        lastname, 
        phone, 
        email,
        cpf,
        street,
        residence_number,
        pub_place,
        city,
        cep,
        state,
        os_historic,
        age)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssss", 
        $name, 
        $lastname, 
        $phone,
        $email,
        $cpf,
        $street,
        $home_number,
        $pub_place,
        $city,
        $cep,
        $state,
        $os_historic,
        $age);

    if ($stmt->execute()) {
        header("Location: client.php");
        exit;
    } else {
        echo "Erro ao criar cliente: " . $stmt->error;
    }
}

if (isset($_POST['edit'])) {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $stmt = $connect->prepare("UPDATE client SET
            name = ?, 
            lastname = ?, 
            phone = ?, 
            email = ?,
            cpf = ?,
            street = ?,
            residence_number = ?,
            pub_place = ?,
            city = ?,
            cep = ?,
            state = ?,
            os_historic = ?,
            age = ?
            WHERE id = ?");

        $stmt->bind_param("ssssssssssssss", 
            $name, 
            $lastname, 
            $phone,
            $email,
            $cpf,
            $street,
            $home_number,
            $pub_place,
            $city,
            $cep,
            $state,
            $os_historic,
            $age,
            $user_id);

        if ($stmt->execute()) {
            header("Location: client.php");
            exit;
        } else {
            echo "Erro ao editar cliente: " . $stmt->error;
        }
    } else {
        echo "ID do cliente não fornecido para edição.";
    }
}

if (isset($_POST['delete'])) {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $stmt = $connect->prepare("DELETE FROM client WHERE id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            header("Location: client.php");
            exit;
        } else {
            echo "Erro ao deletar: " . $stmt->error;
        }
    } else {
        echo "ID do cliente não fornecido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Manager</title>
    <script>
        function showForm(formId) {
            document.querySelectorAll('.form-container').forEach(form => form.style.display = 'none');
            document.getElementById(formId).style.display = 'block';
            document.querySelectorAll('.btn').forEach(btn => btn.style.display = 'none');
        }

        function goBack() {
            window.location.href = 'client.php'; //Redireciona para a página de gerenciamento de clientes
            //Esconde os formulários
            document.querySelectorAll('.form-container').forEach(form => form.style.display = 'none');
            document.querySelectorAll('.btn').forEach(btn => btn.style.display = 'inline-block'); //Mostra os botões
        }

        function loadClientData() {
            const userId = document.getElementById('user_id').value;

            fetch(`getClientdata.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('name').value = data.name;
                        document.getElementById('lastname').value = data.lastname;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('email').value = data.email;
                        document.getElementById('cpf').value = data.cpf;
                        document.getElementById('street').value = data.street;
                        document.getElementById('home_number').value = data.residence_number;
                        document.getElementById('pub_place').value = data.pub_place;
                        document.getElementById('city').value = data.city;
                        document.getElementById('cep').value = data.cep;
                        document.getElementById('state').value = data.state;
                        document.getElementById('os_historic').value = data.os_historic;
                        document.getElementById('age').value = data.age;
                    } else {
                        alert('Cliente não encontrado');
                    }
                })
                .catch(error => console.error('Erro ao carregar os dados:', error));
        }
    </script>
    <link rel="stylesheet" href="/bytecare/css/client.css?v=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <h1 class="text-center">Gerenciar Clientes</h1>
    <div class="d-flex justify-content-center mb-3">
        <button class="btn btn-primary mr-2" onclick="showForm('createForm')">
            <i class="fas fa-plus"></i> CRIAR
        </button>
        <button class="btn btn-warning mr-2" onclick="showForm('editForm')">
            <i class="fas fa-pencil-alt"></i> EDITAR
        </button>
        <button class="btn btn-danger" onclick="showForm('deleteForm')">
            <i class="fas fa-times"></i> DELETAR
        </button>
    </div>

    <!-- Formulário de Criar Cliente -->
    <div id="createForm" class="form-container">
        <h2>Criar Cliente</h2>
        <form method="post">
            <label for="name">Nome:</label><br>
            <input type="text" name="name" id="name" placeholder="Nome" required>
            <label for="lastname">Sobrenome:</label><br>
            <input type="text" name="lastname" id="lastname" placeholder="Sobrenome" required>
            <label for="phone">Telefone:</label><br>
            <input type="text" name="phone" id="phone" placeholder="5551900000000" required>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" placeholder="example@google.com" required>
            <label for="cpf">CPF:</label><br>
            <input type="text" name="cpf" id="cpf" placeholder="00000000000" required>
            <label for="street">Rua:</label><br>
            <input type="text" name="street" id="street" placeholder="Rua" required>
            <label for="home_number">Número:</label><br>
            <input type="text" name="home_number" id="home_number" placeholder="000" required>
            <label for="pub_place">Bairro:</label><br>
            <input type="text" name="pub_place" id="pub_place" placeholder="Bairro" required>
            <label for="city">Cidade:</label><br>
            <input type="text" name="city" id="city" placeholder="Cidade" required>
            <label for="cep">CEP:</label><br>
            <input type="text" name="cep" id="cep" placeholder="00000-000" required>
            <label for="state">Estado:</label><br>
            <input type="text" name="state" id="state" placeholder="Estado" required>
            <label for="os_historic">Histórico de OS:</label><br>
            <input type="text" name="os_historic" id="os_historic" placeholder="Histórico de OS" required>
            <label for="age">Idade:</label><br>
            <input type="text" name="age" id="age" placeholder="Idade" required>
            <button type="submit" name="create">Criar</button>
            <button type="button" onclick="goBack()">Voltar</button>
        </form>
    </div>

    <!-- Formulário de Editar Cliente -->
    <div id="editForm" class="form-container">
        <h2>Editar Cliente</h2>
        <form method="post">
            <label for="user_id">ID do Cliente:</label><br>
            <input type="text" name="user_id" id="user_id" placeholder="ID do Cliente" required>
            <button type="button" onclick="loadClientData()">Carregar Dados</button>

            <label for="name">Nome:</label><br>
            <input type="text" name="name" id="name" placeholder="Nome" required>
            <label for="lastname">Sobrenome:</label><br>
            <input type="text" name="lastname" id="lastname" placeholder="Sobrenome" required>
            <label for="phone">Telefone:</label><br>
            <input type="text" name="phone" id="phone" placeholder="5551900000000" required>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" placeholder="example@google.com" required>
            <label for="cpf">CPF:</label><br>
            <input type="text" name="cpf" id="cpf" placeholder="00000000000" required>
            <label for="street">Rua:</label><br>
            <input type="text" name="street" id="street" placeholder="Rua" required>
            <label for="home_number">Número:</label><br>
            <input type="text" name="home_number" id="home_number" placeholder="000" required>
            <label for="pub_place">Complemento:</label><br>
            <input type="text" name="pub_place" id="pub_place" placeholder="Complemento" required>
            <label for="city">Cidade:</label><br>
            <input type="text" name="city" id="city" placeholder="Cidade" required>
            <label for="cep">CEP:</label><br>
            <input type="text" name="cep" id="cep" placeholder="00000-000" required>
            <label for="state">Estado:</label><br>
            <input type="text" name="state" id="state" placeholder="Estado" required>
            <label for="os_historic">Histórico de OS:</label><br>
            <input type="text" name="os_historic" id="os_historic" placeholder="Histórico de OS" required>
            <label for="age">Idade:</label><br>
            <input type="text" name="age" id="age" placeholder="Idade" required>
            <button type="submit" name="edit">Editar</button>
            <button type="button" onclick="goBack()">Voltar</button>
        </form>
    </div>

    <!-- Formulário de Deletar Cliente -->
    <div id="deleteForm" class="form-container" style="display:none;">
        <h2>Deletar Cliente</h2>
        <form method="post">
            <label for="user_id">ID do Cliente:</label><br>
            <input type="text" name="user_id" id="user_id" placeholder="ID do Cliente" required>
            <button type="submit" name="delete">Deletar</button>
            <button type="button" onclick="goBack()">Voltar</button>
        </form>
    </div>
</body>
</html>

<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/byteCare/templates/footer.php';
?>
