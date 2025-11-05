<div class=" align-items-center" style="max-width: 600px; padding-left: 85px ;">
    <h11  style="text-align: center;"><?php include_once(__DIR__ . "/../include/msg.php") ?></h11>
</div>
<form action="./LoginController.php?action=changePass" method="POST">
     <div class="mb-3">
        <label  class="form-label" for="cpf">CPF:</label>
        <input class="form-control" type="number" id="cpf" name="cpf" 
            maxlength="14" placeholder="Informe número de cpf" value="<?php echo isset($dados['cpf']) ? $dados['cpf'] : '' ?>" />
    </div>
    
    <div class="mb-3">
        <label class="form-label" for="txtPassword">Senha:</label>
        <input class="form-control" type="password" id="txtPassword" name="senha" 
            maxlength="45" placeholder="Informe a senha" value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />
    </div>

    <div class="mb-3">
        <label class="form-label" for="txtConfSenha">Confirmação da senha:</label>
        <input class="form-control" type="password" id="txtConfSenha" name="conf_senha" 
            maxlength="45" placeholder="Informe a confirmação da senha">
    </div>
    <button type="submit">Mudar senha</button>
</form>