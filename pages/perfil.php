<div class="container">
    <div class="perfil">
        <section class="saudacao">
            <h2><i class="fa-solid fa-hands"></i> Olá, <?php echo $_SESSION['nome']?>, o que você gostaria de fazer?</h2>
        </section>
        <br>
        <hr>
        <br>

        <section class="profile-edit">
            <h2>Editar Perfil</h2>
            <div class="edit-profile">
                <label for="nome">O nome do perfil:</label>
                <input type="text" name="nome" placeholder="Nome">
                <label for="email">O email do perfil:</label>
                <input type="email" name="email" placeholder="Email">
                <label for="senha">A senha do perfil:</label>
                <input type="password" name="senha" placeholder="Senha">
                <br>
                <hr>
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

                <input type="submit" value="Atualizar Perfil"> 
            </div>
        </section>
        <br>
        <hr>
        <br>
        <section class="user">
            <h2 style="text-align: center; margin-bottom: 15px">Central de Conta</h2>
            <div class="user-center">
                <a href="logout.php">Sair</a>
                <a onclick="excluir()">Excluir conta</a>
            </div>
        </section>

        <div id="excluir" class="confirmar-excluir">
            <div class="card">
                <div class="flex">
                    <div><h2>Deseja mesmo excluir? </h2></div>
                    <div onclick="fecharExcluir()" class="fechar"><span><i class="fa-solid fa-circle-xmark"></i></span></div>
                </div>
                <p>Lembre-se, essa ação é irreversivel!</p>
                <form method="post" action="excluir.php">
                    <input type="hidden" name="tipo" value="<?php echo $_SESSION['tipo']; ?>">
                    <input type="submit" value="Desejo excluir">
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo INCLUDE_PATH ?>public/js/buscaEstado.js"></script>
<script>
    function excluir() {
        const excluirModal = document.getElementById('excluir');
        excluirModal.style.display = 'flex';
    }
    function fecharExcluir() {
        const excluirModal = document.getElementById('excluir');
        excluirModal.style.display = 'none';
    }

</script>