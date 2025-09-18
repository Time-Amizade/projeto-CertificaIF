<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
$pagina = 'editar';
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__."/../include/menu.php");
?>

<div class="container  d-flex justify-content-center">
    <div class="row w-200" style="margin-top: 20px; margin-bottom:20px">
        
        <!-- card do formulario-->
        <div class="card shadow p-1 rounded-lg " style=" width: 800px; height: auto; background-color: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
            
            
            <div class="mb-3 " style="text-align: center; width: 600px; padding-left: 200px;">
                <?php require_once(__DIR__ . "/../include/msg.php"); ?>
            </div>

            <!-- Formulario único -->
            <form id="frmUsuario" method="POST" 
                  action="<?= BASEURL ?>/controller/PerfilController.php?action=update"
                  enctype="multipart/form-data" >

                <!-- Foto de perfil -->
                <div class="mb-3 text-center">
                    <label class="form-label">Foto de perfil: </label>
                    <div class="col-12 mb-2 text-center">
                        <label for="txtFoto" style="cursor: pointer;">
                            <?php if($dados['usuario']->getFotoPerfil()): ?>
                                <img src="<?= BASEURL_ARQUIVOS . '/' . $dados['usuario']->getFotoPerfil() ?>"
                                    height="300" alt="Foto de perfil">
                            <?php else: ?>
                                <img src="<?= BASEURL ?>/../arquivos/padrao.png"
                                    height="300" alt="Foto padrão">
                            <?php endif; ?>
                        </label>
                    </div>
                    <input class="form-control d-none" type="file" id="txtFoto" name="foto" />
                </div>

                <input type="hidden" name="fotoAnterior" value="<?= $dados['usuario']->getFotoPerfil() ?>">

                <!-- Campos de edição do perfil -->
                  <div class=" align-items-center" style="max-width: 600px; padding-left: 85px ;">
                    <h11  style="text-align: center;"><?php include_once(__DIR__ . "/../include/msg.php") ?></h11>
                </div>
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
                    <label class="form-label" for="cpf">CPF:</label>
                    <input class="form-control" type="number" id="cpf" name="cpf" 
                        maxlength="14" placeholder="Informe número de cpf"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtEmail">Email:</label>
                    <input class="form-control" type="text" id="txtEmail" name="email" 
                        maxlength="45" placeholder="Informe o Email"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtTelefone">Telefone:</label>
                    <input class="form-control" type="number" id="txtTelefone" name="telefone" 
                        maxlength="45" placeholder="Informe o Telefone"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getTelefone() : ''); ?>"/>
                </div>

                 <div class="mb-3">
                    <label class="form-label" for="txtTelefone">Endereço:</label>
                    <input class="form-control" type="text" id="txtTelefone" name="endereco" 
                        maxlength="45" placeholder="Informe o Endereço"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndereco() : ''); ?>"/>
                </div>

                <div>
                     <div class="mb-3">
                    <label class="form-label" for="senha">Senha:</label>
                    <input class="form-control" type="password" id="senha" name="senha" 
                    maxlength="45" placeholder="Informe a Senha"
                    />
                </div>
                
                <div>
                    <div class="mb-3">
                    <label class="form-label" for="txtTelefone"> Confira a Senha:</label>
                    <input class="form-control" type="password" id="confSenha" name="confSenha" 
                    maxlength="45" placeholder="confira a Senha"
                    />
                </div>

              
               <input type="hidden" id="hddId" name="id" value="<?= isset($dados['id']) ? $dados['id'] : ($dados['usuario']->getId() ?? ''); ?>">


                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="<?= BASEURL .'/controller/PerfilController.php?action=view' ?>" class="btn btn-primary">Voltar</a>
                </div>

            </form>            

        </div>
    </div>
</div>

<script>
    const selectFuncao = document.getElementById('selfuncao');
    const matriculaGroup = document.getElementById('matricula-group');

    function toggleMatriculaField() {
        if (selectFuncao && selectFuncao.value.toLowerCase() === 'aluno') {
            matriculaGroup.style.display = 'block';
        } else if(matriculaGroup) {
            matriculaGroup.style.display = 'none';
        }
    }

    // Executa ao carregar a página (útil ao editar)
    window.addEventListener('DOMContentLoaded', toggleMatriculaField);
    // Executa ao mudar a seleção
    if(selectFuncao) selectFuncao.addEventListener('change', toggleMatriculaField);
</script>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
