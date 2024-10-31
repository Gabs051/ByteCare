<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $lastname = trim($_POST['lastname']);
        $age = trim($_POST['age']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $cpf = trim($_POST['cpf']);
        $street = trim($_POST['street']);
        $residence_number = trim($_POST['residence_number']);
        $pub_place = trim($_POST['pub_place']);
        $city = trim($_POST['city']);
        $cep = trim($_POST['cep']);
        $state = trim($_POST['state']);

        $sql = "INSERT INTO client (name, lastname, phone, email, cpf, street, residence_number, pub_place, city, cep, state, age)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $connect -> prepare($sql)) {
            $stmt -> bind_param("ssssssssssss", $name, $lastname, $phone, $email, $cpf, $street, $residence_number, $pub_place, $city, $cep, $state, $age);

            if ($stmt -> execute()) { ?>
                <div class="message">Cadastro realizado com sucesso!</div>
      <?php } else { ?>
                <div class="message">Erro ao realizar o cadastro!</div>
      <?php }
            $stmt -> close();
        } else { ?>
            <div class="message">Erro ao preparar a consulta!</div>
  <?php } 
    } else {
        header("Location: createClient.php");
        exit();
    }
?>

<a href="<?= $BASE_URL ?>client.php">
    <button class="back-button">Ok</button>
</a>

<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/footer.php';
?>