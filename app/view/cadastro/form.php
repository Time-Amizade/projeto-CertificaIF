<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

?>

<h3 class="text-center">
    Cadastrar
</h3>

<div class="container">
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmUsuario" method="POST" 
                action="<?= BASEURL ?>/controller/CadastroController.php?action=save" >
                <div class="mb-3">
                    <label class="form-label" for="txtNome">Nome Completo:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome" 
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="txtData">Data de Nascimento:</label>
                    <input class="form-control" type="date" id="txtData" name="dataNascimento" 
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getDataNascimento() : ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtEmail">Email:</label>
                    <input class="form-control" type="text" id="txtEmail" name="email" 
                        maxlength="45" placeholder="Informe o Email"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtPassword">Senha:</label>
                    <input class="form-control" type="password" id="txtPassword" name="senha" 
                        maxlength="45" placeholder="Informe a senha"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtConfSenha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtConfSenha" name="conf_senha" 
                        maxlength="45" placeholder="Informe a confirmação da senha"
                        value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : '';?>"/>
                </div>

                <div class="mb-3">
                    <label  class="form-label" for="cpf">Cpf:</label>
                    <input class="form-control" type="number" id="cpf" name="cpf" 
                        maxlength="14" placeholder="Informe número de cpf"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="selCurso">Curso:</label>
                    <select class="form-select" name="curso" id="selCurso">
                        <option value="">Selecione seu curso</option>
                        <?php foreach($dados["cursos"] as $curso): ?>
                            <option value="<?= $curso->getId() ?>" 
                            <?php 
                                    if(isset($dados["usuario"]) && $dados["usuario"]->getCursoId() == $curso) 
                                        echo "selected";
                                    ?>    
                            >
                            <?= $curso->getNomeCurso() ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label" for="selfuncao">Função:</label>
                    <select class="form-select" name="funcao" id="selfuncao">
                        <option value="">Selecione sua função</option>
                        <?php foreach($dados["papeis"] as $funcao): ?>
                            <option value="<?= $funcao ?>" 
                            <?php 
                                    if(isset($dados["usuario"]) && $dados["usuario"]->getFuncao() == $funcao) 
                                        echo "selected";
                                    ?>    
                            >
                            <?= $funcao ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3" id="matricula-group" style="display: none;">
                    <label class="form-label" for="cod_matricula">Código de Matricula</label>
                    <input class="form-control" type="number" id="cod_matricula" name="cod_matricula" 
                        placeholder="informe o código de sua matricula"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCodigoMatricula() : ''); ?>">
                </div>

                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                </div>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

<script>
    const selectFuncao = document.getElementById('selfuncao');
    const matriculaGroup = document.getElementById('matricula-group');

    function toggleMatriculaField() {
        if (selectFuncao.value.toLowerCase() === 'aluno') {
            matriculaGroup.style.display = 'block';
        } else {
            matriculaGroup.style.display = 'none';
        }
    }

    // Executa ao carregar a página (útil ao editar)
    window.addEventListener('DOMContentLoaded', toggleMatriculaField);
    // Executa ao mudar a seleção
    selectFuncao.addEventListener('change', toggleMatriculaField);
</script>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>