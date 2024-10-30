<?php

class Usuario {
    public static function excluirUsuario($idUsuario) {
        try {
            $pdo = MySql::conectar();
            $pdo->beginTransaction();
    
            // Obtém o ID do endereço associado ao usuário
            $sql = $pdo->prepare("SELECT endereco FROM `tb_usuario` WHERE id = ?");
            $sql->execute([$idUsuario]);
            $enderecoId = $sql->fetchColumn();
    
            // Exclui o endereço associado se existir
            if ($enderecoId) {
                $sql = $pdo->prepare("DELETE FROM `tb_endereco` WHERE id = ?");
                $sql->execute([$enderecoId]);
            }
    
            // Exclui o usuário
            $sql = $pdo->prepare("DELETE FROM `tb_usuario` WHERE id = ?");
            $sql->execute([$idUsuario]);
    
            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Erro ao excluir usuário: " . $e->getMessage());
            return false;
        }
    }
    
    public static function atualizarUsuario($nome, $senha) {
        try {
            $pdo = MySql::conectar();

            // Verifica se uma nova senha foi fornecida
            if (!empty($senha)) {
                // Atualiza com nova senha
                $sql = $pdo->prepare("UPDATE `tb_usuario` SET nome = ?, senha = ? WHERE email = ?");
                $sql->execute(array($nome, $senha, $_SESSION['email']));
            } else {
                // Atualiza sem alterar a senha
                $sql = $pdo->prepare("UPDATE `tb_usuario` SET nome = ? WHERE email = ?");
                $sql->execute(array($nome, $_SESSION['email']));
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

    public static function login($email, $senha) {
        try {
            $pdo = MySql::conectar();
            $sql = $pdo->prepare("SELECT * FROM tb_usuario WHERE email = ?");
            $sql->execute([$email]);
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    
            // Verifica se o usuário foi encontrado
            if ($usuario && $senha == $usuario['senha']) {
                // Inicia a sessão e armazena os dados do usuário
                $_SESSION['login'] = true;
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['tipo'] = 'user';
                $_SESSION['email'] = $usuario['email'];
                return true;
            }
            
            return false; // Senha incorreta ou usuário não encontrado
        } catch (PDOException $e) {
            error_log("Erro ao realizar login: " . $e->getMessage());
            return false;
        }
    }
    

    public static function cadastrarUsuario($nome, $email, $senha, $estado, $cidade, $numero, $cep, $cpf, $fone) {
        try {
            $pdo = MySql::conectar();
            
            // Verifica se o email ou CPF já estão cadastrados
            if (self::userExists($email)) {
                return ['success' => false, 'message' => 'O email já está em uso.'];
            }
            if (self::cpfExists($cpf)) {
                return ['success' => false, 'message' => 'O CPF já está em uso.'];
            }

            $pdo->beginTransaction();

            // Cadastro do endereço
            $sql = $pdo->prepare("INSERT INTO tb_endereco (estado, cidade, numero, cep) VALUES (?, ?, ?, ?)");
            $sql->execute([$estado, $cidade, $numero, $cep]);
            $idEndereco = $pdo->lastInsertId();

            $sql = $pdo->prepare("INSERT INTO tb_usuario (nome, email, senha, cpf, endereco, fone) VALUES (?, ?, ?, ?, ?, ?)");
            $sql->execute([$nome, $email, $senha, $cpf, $idEndereco, $fone]);

            $pdo->commit();
            return ['success' => true, 'message' => 'Cadastro realizado com sucesso!'];
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no cadastro.'];
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
