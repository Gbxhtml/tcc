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

    public static function cpfExists($cpf) {
        try {
            $sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_usuario` WHERE cpf = ?");
            $sql->execute(array($cpf));
            return $sql->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar existência do CPF: " . $e->getMessage());
            return false;
        }
    }
    
    public static function cadastrarUsuario($nome, $senha, $email, $estado, $cidade, $numero, $cep, $cpf, $phone) {
        try {
            // Verifica se o usuário ou o CPF já existe
            if (self::userExists($email)) {
                return ['success' => false, 'message' => 'O email já está em uso.'];
            }
            
            if (self::cpfExists($cpf)) {
                return ['success' => false, 'message' => 'O CPF já está cadastrado.'];
            }
        
            // Definir o cargo padrão para "USUARIO"
            $cargo = "USUARIO";
        
            // Conexão com o banco de dados
            $pdo = MySql::conectar();
        
            // Inicia uma transação
            $pdo->beginTransaction();
        
            $sql = $pdo->prepare("INSERT INTO `tb_endereco` (estado, cidade, numero, cep) VALUES (?, ?, ?, ?)");
            $sql->execute(array($estado, $cidade, $numero, $cep));
        
            // Obtém o ID do endereço inserido
            $id_endereco = $pdo->lastInsertId();
        
            $sql = $pdo->prepare("INSERT INTO `tb_usuario` (nome, senha, email, cargo, fone, endereco, cpf) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sql->execute(array($nome, $senha, $email, $cargo, $phone, $id_endereco, $cpf));
        
            // Confirma a transação
            $pdo->commit();
        
            return ['success' => true, 'message' => 'Cadastro bem-sucedido!'];
        } catch (PDOException $e) {
            // Se houver um erro, reverte a transação
            $pdo->rollBack();
        
            // Log de erro
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro ao cadastrar usuário. Tente novamente mais tarde.'];
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