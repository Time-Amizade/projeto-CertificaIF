<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

?>

<h3 class="text-center">
    <?php echo "Inserir"; ?> 
    Usuário
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmUsuario" method="POST" 
                action="<?= BASEURL ?>/controller/CadastroController.php?action=save" >
                <div class="mb-3">
                    <label class="form-label" for="txtNome">NomeCompleto:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome" 
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                </div>
                
                <div class="mb-3">
                    <label class="form-label" form="txtData">Data de Nascimento:</label>
                    <input form="form-control" type="date" id="date" name="dataNascimento">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtEmail">Email:</label>
                    <input class="form-control" type="text" id="txtEmail" name="Email" 
                        maxlength="15" placeholder="Informe o Email"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getLogin() : ''); ?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtSenha">Senha:</label>
                    <input class="form-control" type="password" id="txtPassword" name="senha" 
                        maxlength="15" placeholder="Informe a senha"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtConfSenha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtConfSenha" name="conf_senha" 
                        maxlength="15" placeholder="Informe a confirmação da senha"
                        value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : '';?>"/>
                </div>

                <div class="mb-3">
                    <label  class="form-label" for="telefone">Telefone:</label>
                    <input class="form-control" type="number" id="telefone" name="telefone" maxlength="14" placeholder="informe número de telefone">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="endereco">Endereco</label>
                    <input class="form-control" type="text" id="txtEndereco" name="Endereco" placeholder="informe seu endereco">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="cod_matricula">Código de Matricula</label>
                    <input class="form-control" type="number" id="cod_matricula" name="cod_matricula" placeholder="informe o código de sua matricula">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="selfuncao">função:</label>
                    <select class="form-select" name="funcao" id="selfuncao">
                        <option value="">Selecione o papel</option>
                        <?php foreach($dados["papeis"] as $papel): ?>
                            <option value="<?= $papel ?>" 
                                <?php 
                                    if(isset($dados["usuario"]) && $dados["usuario"]->getPapel() == $papel) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $papel ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

               

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                </div>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

   

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>