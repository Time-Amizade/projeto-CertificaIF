<?php
#Nome do arquivo: perfil/perfil.php
#Objetivo: interface para perfil dos usuários do sistema
$pagina = 'perfil';

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
$papel;
if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR){
    $papel = "admin";
} else if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::COORDENADOR){
    $papel = "coordenador";
}else if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ALUNO){
    $papel = "aluno";
}
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/perfil.css">

<div class="container"> 
    <div class="row">

        <!-- COLUNA PERFIL (AMARELA) -->
        <div class="col-6" style="background-color: yellow;">

            <div class="row">
                <div class="col-6">
                    <h3 class="text-center">Perfil</h3>
                    <div class="row mt-5">
                        <div class="col-6">
                            <?php if($dados['usuario']->getFotoPerfil()): ?>
                                <img src="<?= BASEURL_ARQUIVOS . '/' . $dados['usuario']->getFotoPerfil() ?>"
                                    height="300" alt="Foto de perfil">
                            <?php else: ?>
                                <img src="<?= BASEURL ?>/../arquivos/padrao.png"
                                    height="300" alt="Foto padrão">
                            <?php endif; ?>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Nome:</span>
                            <span><?= $dados['usuario']->getNome() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Email:</span>
                            <span><?= $dados['usuario']->getEmail() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Data de Nascimento:</span>
                            <span><?= $dados['usuario']->getDataNascimento() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">CPF:</span>
                            <span><?= $dados['usuario']->getCPF() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Telefone:</span>
                            <span><?= $dados['usuario']->getTelefone() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Endereço:</span>
                            <span><?= $dados['usuario']->getEndereco() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Data de Nascimento:</span>
                            <span><?= $dados['usuario']->getDataNascimento() ?></span>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="fw-bold">Função:</span>
                            <span><?= $dados['usuario']->getFuncao() ?></span>
                        </div>

                        <?php if($papel != "admin"): ?>  
                            <div class="col-12 mb-2">
                                <span class="fw-bold">Curso:</span>
                                <span><?= $dados['usuario']->getCursoId()->getNomeCurso() ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if($papel == "aluno"): ?>
                            <div class="col-12 mb-2">
                                <span class="fw-bold">Horas Validadas:</span>
                                <span><?= $dados['usuario']->getHorasValidadas() ?? 0 ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if($papel == "aluno"): ?>         
                            <div class="col-12 mb-2">
                                <span class="fw-bold">Código de Matricula:</span>
                                <span><?= $dados['usuario']->getCodigoMatricula() ?></span>
                            </div>
                        <?php endif; ?>   
                    </div>
                </div>  
            </div>

            <div class="row" style="margin-top: 30px;">
                <div class="col-12 d-flex gap-2">
                    <a class="btn btn-secondary" href="<?= HOME_PAGE ?>">Voltar</a>
                    <a class="btn btn-success" href="<?= BASEURL ?>/controller/PerfilController.php?action=edit&id=<?= $dados['usuario']->getId() ?>">Editar</a>
                </div>
            </div>
        </div>  

        <!-- informações ao lado -->
        <div class="col-6" >
            
            <canvas id="graficoPizza" width="300" height="300"></canvas>
            <div id="legenda" style="margin-top: 15px;"></div>
        
        </div>
        <script>
            const ID_USUARIO = <?= $dados['usuario']->getId() ?>;
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="<?= BASEURL ?>/view/js/graficoHoras_ajax.js"> </script> 




    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
