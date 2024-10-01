<?php

class Usuario {

    public static function atualizarUsuario($nome, $senha) {
        try {
            $pdo = MySql::conectar();

            // Verifica se uma nova senha foi fornecida
            if (!empty($senha)) {
                // Atualiza com nova senha
                $sql = $pdo->prepare("UPDATE `tb_usuario` SET nome = ?, senha = ?, WHERE email = ?");
                $sql->execute(array($nome, $senha, $_SESSION['email']));
            } else {
                // Atualiza sem alterar a senha
                $sql = $pdo->prepare("UPDATE `tb_usuario` SET nome = ?, WHERE email = ?");
                $sql->execute(array($nome,  $_SESSION['email']));
            }

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function userExists($email) {
        try {
            $sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_usuario` WHERE email = ?");
            $sql->execute(array($email));
            return $sql->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar existência do usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function loginUsuario($email, $senha) {
        try {
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_usuario` WHERE email = ?");
            $sql->execute(array($email));
            
            if ($sql->rowCount() == 1) {
                $info = $sql->fetch();
                if ($senha === $info['senha']) {
                    $_SESSION['login'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['nome'] = $info['nome'];
                    $_SESSION['user_id'] = $info['ID'];
                    return true;
                } else {
                    error_log("Senha incorreta para o email: " . $email);
                    return false;
                }
            } else {
                error_log("Email não encontrado: " . $email);
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao realizar login: " . $e->getMessage());
            return false;
        }
    }

    public static function cadastrarUsuario($nome, $senha, $email) {
        try {
            if (self::userExists($email)) {
                return false;
            }

            $cargo = "USUARIO";


            $sql = MySql::conectar()->prepare("INSERT INTO `tb_usuario` (nome, senha, email, cargo) VALUES (?, ?, ?, ?)");
            return $sql->execute(array($nome, $senha, $email, $cargo, ));
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function obterUsuario($email) {
        try {
            $pdo = MySql::conectar();
            $sql = $pdo->prepare("SELECT * FROM `tb_usuario` WHERE email = ?");
            $sql->execute(array($email));
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);

            return $usuario;
        } catch (PDOException $e) {
            error_log("Erro ao obter informações do usuário: " . $e->getMessage());
            return [];
        }
    }
}