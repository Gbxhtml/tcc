<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CompartilhaAção - Login</title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/style.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/login.css">
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

            <input type="submit" value="Login">
            
            <br>
            <hr>
            <br>

            <h3>Não possue uma conta? <a href="cadastro">cadastre-se</a></h3>
        </div>
    </form>
</body>
</html>