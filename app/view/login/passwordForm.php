<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema
$pagina ="passwordChange";
require_once(__DIR__ . "/../include/header.php");
?>

<div class="d-flex justify-content-center mt-4">
    <div class="card shadow-lg border-0" style="max-width: 450px; width: 100%;">

        <div class="card-header bg-dark text-success text-center">
            <h5 class="m-0">Alterar senha</h5>
        </div>

        <div class="card-body bg-light">

            <!-- MENSAGEM DE ERRO / SUCESSO -->
            <div class="mb-3">
                <?php include_once(__DIR__ . "/../include/msg.php") ?>
            </div>

            <form action="./LoginController.php?action=changePass" method="POST">

                <div class="mb-3">
                    <label class="form-label fw-bold" for="cpf">CPF:</label>
                    <input class="form-control" type="tel" id="cpf" name="cpf"
                        maxlength="14" placeholder="Informe número de CPF"
                        value="<?php echo isset($dados['cpf']) ? $dados['cpf'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold" for="txtPassword">Senha:</label>
                    <input class="form-control" type="password" id="txtPassword" name="senha"
                        maxlength="45" placeholder="Informe a senha"
                        value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold" for="txtConfSenha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtConfSenha" name="conf_senha"
                        maxlength="45" placeholder="Informe a confirmação da senha">
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold mb-2">
                    Mudar senha
                </button>

                <a href="<?= LOGIN_PAGE ?>" class="btn btn-primary w-100 fw-bold">
                    Voltar
                </a>

            </form>
        </div>
    </div>
</div>

<script>
    cpf.oninput = () => {
        cpf.value = cpf.value
            .replace(/\D/g, '')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    };
</script>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
