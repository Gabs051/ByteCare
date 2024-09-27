<?php 
 ini_set('display_errors',1);
 ini_set('display_startup_erros',1);
 error_reporting(E_ALL);
 include_once("helpers/url.php");

 session_start();

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $user = $_POST['user'];
     $password = $_POST['password'];

     if($user == "gabs" && $password == "1234"){
         $_SESSION['loggedin'] = true;
         header("Location: cadastro/cadastro.php");
         $error = null;
     }
     else{
         $error = "Usuário ou senha incorretos.";
     }
 }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="<?= $BASE_URL?>/css/loginStyle.css">
</head>
<body>
    <div class="login-class" align="center">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <h4>Faça seu Login</h4>
            <div class="buttonUser-class">
                <label for="user"></label>
                <input type="text" name="user" id="user" placeholder="usuário">
            </div>
            <div class="buttonPassword-class">
                <label for="password"></label>
                <input type="password" name="password" id="password" placeholder="senha">
            </div>
            <div class="submit-class">
                <input type="submit" value="Logar">
            </div>
            <?php
                if(isset($error)){?>
                    <div class="error-class">
                        <p style="color: red; margin-top: 10px;"><?php echo $error; ?></p>
                    </div>
          <?php }?>
        </form>
    </div>

</body>
</html>