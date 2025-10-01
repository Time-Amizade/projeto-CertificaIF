<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/home.css">

<h3 class="text-center">Página inicial do sistema</h3>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 d-none" id="filtroContainer">
            <div class="bg-primary p-3 rounded">
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
        
        <div class="col-md-9" id='listaDadosContainer'> 
            <div class="row" id="listaDados">
                </div>
        </div>
        
    </div>
</div>

<script src="<?= BASEURL ?>/view/js/home_ajax.js"> const tipoUsuario = "<?php echo $_SESSION[SESSAO_USUARIO_PAPEL]; ?>"; </script> 

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
