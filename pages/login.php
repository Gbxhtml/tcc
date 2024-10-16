<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CompartilhaAção - Login</title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/style.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/login.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <form method="POST">
        <div class="container">
            <img src="<?php echo INCLUDE_PATH; ?>public/images/logo.png" alt="Logo do sistema">    
            <h2>Faça seu Login</h2>
            <br>
            <label for="email">Insira seu Email:</label>
            <input id="emai" name="email" type="text" placeholder="Email">

            <label for="password">Insira sua Senha:</label>
            <input id="password" name="password" type="password" placeholder="Senha">
            <input type="hidden" name="acao">

            <input type="submit" value="Login">
            
            <br>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    if (Usuario::loginUsuario($email, $password)) {
                        if (isset($_POST['acao'])) {
                            setcookie('email', $email, time() + (60*60*24*30), '/');
                            setcookie('password', $password, time() + (60*60*24*30), '/');
                        }
                        header('Location: '.INCLUDE_PATH);
                        exit();
                    } else {
                        echo '<p class="error">Nome de usuário ou senha incorretos.</p>';
                    }
                }
            ?>
            <hr>
            <br>

            <h3>Não possue uma conta? <a href="cadastro">Cadastre-se</a></h3>
        </div>
    </form>
</body>
</html>