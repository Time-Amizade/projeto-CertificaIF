<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema
$pagina = 'login';

require_once(__DIR__ . "/../include/header.php");
?>
<div class="container d-flex justify-content-center" style="padding-top: 80px;">
    <div class="row w-100" style="max-width: 1000px;">
        <!-- CARD DO FORMULÁRIO -->
        <div class="col-md-6">
            <div class="card shadow p-4 rounded" style="width: 700px; background-color: #f8f9fa;">

                <img src="<?= BASEURL . '/view/img/anexo.png'?>" style="display: block; margin: 0 auto 10px auto; max-width: 500px%; height: auto;">

                <h4 style="text-align: center;">login:</h4>

                <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="txtEmail">Login:</label>
                        <input type="text" class="form-control" name="email" id="txtEmail"
                               maxlength="15" placeholder="Informe o email"
                               value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="txtSenha">Senha:</label>
                        <input type="password" class="form-control" name="senha" id="txtSenha"
                               maxlength="15" placeholder="Informe a senha"
                               value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />        
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Acessar</button>
                    <button class="btn btn-success mt-3">
                        <a href="<?= BASEURL . '/controller/CadastroController.php?action=create' ?>" style="color: white; text-decoration: none;">Cadastrar</a>
                    </button>
                </form>
            </div>
        </div>

        <!-- MENSAGENS DE ERRO AO LADO -->
        <div class="col-md-6 d-flex align-items-center">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
