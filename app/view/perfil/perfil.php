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
    <!-- BLOCO ESQUERDO - INFORMAÇÕES DO PERFIL -->
    <div class="perfil-info">
        <h3>Perfil</h3>

        <?php if($dados['usuario']->getFotoPerfil()): ?>
            <img src="<?= BASEURL_ARQUIVOS . '/' . $dados['usuario']->getFotoPerfil() ?>" alt="Foto de perfil">
        <?php else: ?>
            <img src="<?= BASEURL ?>/../arquivos/padrao.png" alt="Foto padrão">
        <?php endif; ?>

        <div class="info-item"><span>Nome:</span><span><?= $dados['usuario']->getNome() ?></span></div>
        <div class="info-item"><span>Email:</span><span><?= $dados['usuario']->getEmail() ?></span></div>
        <div class="info-item"><span>Data de Nascimento:</span><span><?= $dados['usuario']->getDataNascimento() ?></span></div>
        <div class="info-item"><span>CPF:</span><span><?= $dados['usuario']->getCPF() ?></span></div>
        <div class="info-item"><span>Telefone:</span><span><?= $dados['usuario']->getTelefone() ?></span></div>
        <div class="info-item"><span>Endereço:</span><span><?= $dados['usuario']->getEndereco() ?></span></div>
        <div class="info-item"><span>Função:</span><span><?= $dados['usuario']->getFuncao() ?></span></div>

        <?php if($papel != "admin"): ?>  
            <div class="info-item"><span>Curso:</span><span><?= $dados['usuario']->getCursoId()->getNomeCurso() ?></span></div>
        <?php endif; ?>

        <?php if($papel == "aluno"): ?>
            <div class="info-item"><span>Horas Validadas:</span><span><?= $dados['usuario']->getHorasValidadas() ?? 0 ?></span></div>
            <div class="info-item"><span>Código de Matrícula:</span><span><?= $dados['usuario']->getCodigoMatricula() ?></span></div>
        <?php endif; ?>

        <div class="botoes">
            <a class="btn btn-secondary" href="<?= HOME_PAGE ?>">Voltar</a>
            <a class="btn btn-success" href="<?= BASEURL ?>/controller/PerfilController.php?action=edit&id=<?= $dados['usuario']->getId() ?>">Editar</a>
        </div>
    </div>

<?php
$mostrarGrafico = false;

if ($papel == "aluno") {
    $mostrarGrafico = true;
} else if ($papel == "coordenador") {
    // Coordenador só vê gráfico se estiver visualizando um aluno
    $usuarioVisualizado = $dados['usuario'];
    if ($usuarioVisualizado->getFuncao() == UsuarioFuncao::ALUNO) {
        $mostrarGrafico = true;
    }
}

if ($mostrarGrafico): ?>
    <!-- BLOCO DIREITO - GRÁFICO -->
    <div class="grafico-area">
        <canvas id="graficoPizza" width="300" height="300"></canvas>
        <div id="legenda"></div>
    </div>
<?php endif; ?>

<!-- SCRIPTS DO GRÁFICO -->
<script>
    const ID_USUARIO = <?= $dados['usuario']->getId() ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= BASEURL ?>/view/js/graficoHoras_ajax.js"></script>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
