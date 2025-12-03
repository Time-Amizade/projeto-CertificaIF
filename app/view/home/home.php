<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
$pagina = 'home';
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

$papel;
if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ALUNO){
    $papel = "aluno";
} else {
    $papel = "todos";
}
?>

<?php
$css = ($papel == "aluno") ? "home_aluno.css" : "home.css";
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/<?= $css ?>">



<h3 class="text-center">Bem Vindo, <?= $nome ?> ! 👋</h3>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 d-none" id="filtroContainer">
            <div class="bg-success p-3 rounded">
                <h2 class="mb-4 text-white">Filtro</h2>
                
                <div class="mb-3">
                    <label for="titulo" class="form-label text-white">Buscar por título</label>
                    <input type="text" id="titulo" class="form-control" onchange='carregarDados("<?= BASEURL ?>")'>
                </div>

                <div class="mb-3">
                    <label for="horas" class="form-label text-white">Horas (maior que)</label>
                    <input type="number" id="horas" class="form-control" onchange='carregarDados("<?= BASEURL ?>")'>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label text-white">Status</label>
                    <select id="status" class="form-select" onchange='carregarDados("<?= BASEURL ?>")'>
                        <option value="">Selecione o Status</option>
                        <option value="PENDENTE">PENDENTE</option>
                        <option value="APROVADO">APROVADO</option>
                        <option value="RECUSADO">RECUSADO</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 bg-suc" id='listaDadosContainer'> 
            <?php if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR): ?>
                <h3>Cadastros de coordenadores</h3>
            <?php endif; ?>
            <div class="row" id="listaDados">
            </div>
            
        </div>
        <?php if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR): ?>
    <div id="botaoFixoGerenciar">
        <div class="card shadow-lg d-flex justify-content-center align-items-center text-center" 
            onclick="window.location.href='<?= BASEURL . '/controller/CursoController.php?action=list' ?>'">
            
            <div class="card-body justify-content-center align-items-center text-center">
                <h1 style="font-size: 110px;">📚</h1>
                <h4>Gerenciar Cursos</h4>
            </div>

        </div>
    </div>
<?php endif; ?>
    </div>
</div>

<script src="<?= BASEURL ?>/view/js/home_ajax.js"> const tipoUsuario = "<?php echo $_SESSION[SESSAO_USUARIO_PAPEL]; ?>"; </script> 

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
