<?php

$email = $_SESSION['email'];
$usuario = Usuario::obterUsuario($email);

$url = isset($_GET['url']) ? $_GET['url'] : 'home';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CompartilhaAção - <?php echo ucfirst($url); ?></title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/style.css">
    <script src="https://kit.fontawesome.com/d9dda7c4a9.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<div class="container-main">
    <div class="sidebar">
        <div class="profile">
            <a href="perfil" style="text-decoration: none;">
                <h2><?php echo $_SESSION['nome']; ?></h2>
                <a class="logout" href="<?php echo INCLUDE_PATH; ?>logout.php" class="button"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
            </a>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="<?php echo INCLUDE_PATH; ?>"><i class="fa-solid fa-hand-holding-dollar"></i> Doar</a></li>
                <li><a href="<?php echo INCLUDE_PATH; ?>"><i class="fa-solid fa-landmark"></i> Instituições</a></li>
            </ul>
        </nav>
        <img class="logo" src="<?php echo INCLUDE_PATH; ?>/public/images/logo.png" alt="Logo CompartilhaAção">
    </div>
    <div class="main">
