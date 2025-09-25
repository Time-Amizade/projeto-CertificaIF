<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/home.css">

<h3 class="text-center">Página inicial do sistema</h3>

<div >
    <div class="container-mt-5">
        <h2 class="mb-4">Filtro dos Comprovantes</h2>

        <div class="column mb-4">
            <div class="col-md-4 p-2">
                <input type="text" id="titulo" class="form-control" placeholder="Buscar por título" onchange='carregarDados("<?= BASEURL ?>")'>
            </div>
            <div class="col-md-4 p-2">
                <input type="number" id="horas" class="form-control" placeholder="Horas (maior que)" onchange='carregarDados("<?= BASEURL ?>")'>
            </div>
            <div class="col-md-4 p-2">
                <select id="status" class="form-select" onchange='carregarDados("<?= BASEURL ?>")'>
                    <option value="">Selecione o Status</option>
                    <option value="PENDENTE">PENDENTE</option>
                    <option value="APROVADO">APROVADO</option>
                    <option value="RECUSADO">RECUSADO</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class='container' id='listaDados'>
</div>

<script src="<?= BASEURL ?>/view/js/home_ajax.js"> const tipoUsuario = "<?php echo $_SESSION[SESSAO_USUARIO_PAPEL]; ?>"; </script> 

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
