<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	ini_set('error_log', 'logs/php_error_log'); 

	$autoload = function($class) {
		include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);

	define('INCLUDE_PATH', 'http://localhost/tcc/');
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASSWORD', '');
	define('DATABASE', 'compartilhaacao');

	function verificarCargo($cargoPermitido) {
		if (!isset($_SESSION['cargo']) || $_SESSION['cargo'] !== $cargoPermitido) {
			header('Location: '.INCLUDE_PATH.'logout');
			exit();
		}
	}

	function verificarCargosPermitidos($cargosPermitidos) {
		if (!isset($_SESSION['cargo']) || !in_array($_SESSION['cargo'], $cargosPermitidos)) {
			header('Location: '.INCLUDE_PATH.'erro-permissao');
			exit();
		}
	}
?>
