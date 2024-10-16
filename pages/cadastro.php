<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CompartilhaAção - Cadastro</title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/style.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>public/styles/login.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <form method="post"> 
        <div class="container">
            <img src="<?php echo INCLUDE_PATH; ?>public/images/logo.png" alt="Logo do sistema">    
            <h2>Faça seu Cadastro</h2>
            <br>
            <label for="nome">Insira seu Nome:</label>
            <input id="nome" name="nome" type="text" placeholder="Seu nome aqui.">
            <label for="email">Insira seu Email:</label>
            <input id="email" name="email" type="text" placeholder="Email">
            <label for="senha">Insira sua Senha:</label>
            <input id="senha" name="senha" type="password" placeholder="Senha">
            <br>
            <hr>
            <br>
            <h3>Endereço:</h3>
            <div class="endereco">
                <label for="estado">Selecione seu Estado:</label>
                <select id="estado" name="estado">
                    <option value="">Selecione o Estado</option>
                </select>

                <label for="cidade">Selecione sua Cidade:</label>
                <select id="cidade" name="cidade" disabled>
                    <option value="">Selecione o Estado primeiro</option>
                </select>

                <div class="flex">
                    <div class="w-50">
                        <label for="bairro">Escreva seu Bairro:</label>
                        <input id="bairro" name="bairro" type="text" placeholder="Bairro">
                    </div>

                    <div class="w-50">
                        <label for="rua">Escreva sua Rua:</label>
                        <input id="rua" name="rua" type="text" placeholder="Rua">
                    </div>
                </div>
                <div class="flex">
                    <div class="w-50">
                        <label for="numero">Escreva seu Numero de residencia:</label>
                        <input id="numero" name="numero" type="number" placeholder="Numero">
                    </div>
                    <div class="w-50">
                        <label for="cep">Escreva seu CEP:</label>
                        <input id="cep" name="cep" type="cep" placeholder="Cep">
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <h3>Informações pessoais:</h3>
            <div class="info">
                <label for="cpf">Escreva seu CPF:</label>
                <input id="cpf" name="cpf" type="cpf" placeholder="CPF">

                <label for="phone">Escreva seu Telefone:</label>
                <input id="phone" name="phone" type="tel" placeholder="Telefone">
            </div>

            <input type="submit" value="Cadastrar"> 
            
            <br>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $estado = $_POST['estado'];
                $cidade = $_POST['cidade'];
                $numero = $_POST['numero'];
                $cep = $_POST['cep'];
                $cpf = $_POST['cpf'];
                $phone = $_POST['phone'];
            
                $result = Usuario::cadastrarUsuario($nome, $senha, $email, $estado, $cidade, $numero, $cep, $cpf, $phone);
            
                if ($result['success']) {
                    echo '<p class="success">' . $result['message'] . ' <a href="login">Faça login</a>.</p>';
                } else {
                    echo '<p class="error">' . $result['message'] . '</p>';
                }
            }
            ?>
            <hr>
            <br>

            <h3>Possui uma conta? <a href="login">Faça login</a></h3>
        </div>
    </form>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');

    // Função para buscar estados
    function buscarEstados() {
        fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
            .then(response => response.json())
            .then(estados => {
                estados.sort((a, b) => a.nome.localeCompare(b.nome)); // Ordenar por nome
                estados.forEach(estado => {
                    let option = document.createElement('option');
                    option.value = estado.id;
                    option.textContent = estado.nome;
                    estadoSelect.appendChild(option);
                });
            });
    }

    // Função para buscar cidades de um estado
    function buscarCidades(estadoId) {
        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`)
            .then(response => response.json())
            .then(cidades => {
                cidadeSelect.innerHTML = '<option value="">Selecione a Cidade</option>'; // Limpa as opções anteriores
                cidadeSelect.disabled = false;
                cidades.forEach(cidade => {
                    let option = document.createElement('option');
                    option.value = cidade.nome;
                    option.textContent = cidade.nome;
                    cidadeSelect.appendChild(option);
                });
            });
    }

    // Evento de mudança no estado
    estadoSelect.addEventListener('change', function () {
        let estadoId = estadoSelect.value;
        if (estadoId) {
            buscarCidades(estadoId);
        } else {
            cidadeSelect.innerHTML = '<option value="">Selecione o Estado primeiro</option>';
            cidadeSelect.disabled = true;
        }
    });

    // Inicializa buscando os estados
    buscarEstados();
});

</script>