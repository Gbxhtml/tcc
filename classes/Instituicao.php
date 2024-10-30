<?php

class Instituicao {
    public static function excluirInstituicao($idInstituicao) {
        try {
            $pdo = MySql::conectar();
            $pdo->beginTransaction();
    
            // Obtém o ID do endereço associado à instituição
            $sql = $pdo->prepare("SELECT endereco FROM `tb_instituicao` WHERE id = ?");
            $sql->execute([$idInstituicao]);
            $enderecoId = $sql->fetchColumn();
    
            // Exclui o endereço associado se existir
            if ($enderecoId) {
                $sql = $pdo->prepare("DELETE FROM `tb_endereco` WHERE id = ?");
                $sql->execute([$enderecoId]);
            }
    
            // Exclui a instituição
            $sql = $pdo->prepare("DELETE FROM `tb_instituicao` WHERE id = ?");
            $sql->execute([$idInstituicao]);
    
            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Erro ao excluir instituição: " . $e->getMessage());
            return false;
        }
    }
   
    public static function atualizarInstituicao($nome_fantasia, $descricao, $senha) {
        try {
            $pdo = MySql::conectar();

            // Verifica se uma nova senha foi fornecida
            if (!empty($senha)) {
                // Atualiza com nova senha
                $sql = $pdo->prepare("UPDATE `tb_instituicao` SET nome_fantasia = ?, descricao = ?, senha = ? WHERE email = ?");
                $sql->execute(array($nome_fantasia, $descricao, password_hash($senha, PASSWORD_BCRYPT), $_SESSION['email']));
            } else {
                // Atualiza sem alterar a senha
                $sql = $pdo->prepare("UPDATE `tb_instituicao` SET nome_fantasia = ?, descricao = ? WHERE email = ?");
                $sql->execute(array($nome_fantasia, $descricao, $_SESSION['email']));
            }

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao atualizar instituição: " . $e->getMessage());
            return false;
        }
    }

    public static function instituicaoExists($email) {
        try {
            $pdo = MySql::conectar();
            $sql = $pdo->prepare("SELECT id FROM tb_instituicao WHERE email = ?");
            $sql->execute([$email]);
            return $sql->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar instituição: " . $e->getMessage());
            return false;
        }
    }

    public static function cadastrarInstituicao($estado, $cidade, $bairro, $rua, $numero, $cep, $email, $senha, $nome_fantasia, $descricao, $cnpj, $fone, $obs) {
        try {
            $pdo = MySql::conectar();
            if (self::instituicaoExists($email)) {
                return ['success' => false, 'message' => 'O email já está em uso.'];
            }
            $pdo->beginTransaction();

            $sql = $pdo->prepare("INSERT INTO tb_endereco (estado, cidade, bairro, rua, numero, cep) VALUES (?, ?, ?, ?, ?, ?)");
            $sql->execute([$estado, $cidade, $bairro, $rua, $numero, $cep]);
            $enderecoId = $pdo->lastInsertId();

            $sql = $pdo->prepare("INSERT INTO tb_instituicao (endereco, email, senha, nome_fantasia, descricao, cnpj, fone, obs) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->execute([$enderecoId, $email, $senha, $nome_fantasia, $descricao, $cnpj, $fone, $obs]);

            $pdo->commit();
            return ['success' => true, 'message' => 'Cadastro de instituição realizado com sucesso!'];
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Erro ao cadastrar instituição: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no cadastro de instituição.'];
        }
    }

    public static function login($email, $senha) {
        try {
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_instituicao` WHERE email = ?");
            $sql->execute(array($email));

            if ($sql->rowCount() == 1) {
                $info = $sql->fetch();
                if ($senha == $info['senha']) {
                    $_SESSION['login'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['nome'] = $info['nome_fantasia'];
                    $_SESSION['img'] = $info['img'];
                    $_SESSION['tipo'] = 'instituicao';
                    $_SESSION['instituicao_id'] = $info['id'];
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

    public static function cnpjExists($cnpj) {
        try {
            $sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_instituicao` WHERE cnpj = ?");
            $sql->execute(array($cnpj));
            return $sql->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar existência do CNPJ: " . $e->getMessage());
            return false;
        }
    }

    public static function obterInstituicao($email) {
        try {
            $pdo = MySql::conectar();
            $sql = $pdo->prepare("SELECT * FROM `tb_instituicao` WHERE email = ?");
            $sql->execute(array($email));
            $instituicao = $sql->fetch(PDO::FETCH_ASSOC);

            return $instituicao;
        } catch (PDOException $e) {
            error_log("Erro ao obter informações da instituição: " . $e->getMessage());
            return [];
        }
    }
}
