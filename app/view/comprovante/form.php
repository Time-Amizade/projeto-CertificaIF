<?php
#Nome do arquivo: comprovante/form.php
#Objetivo: interface para cadastros os cursos do sistema
$pagina = 'comprovante';

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/comprovante.css">

<h3 class="text-center">
    <?php if($dados['idComp'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    Comprovante
</h3>

<div class="container">
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmComp" method="POST" action="<?= BASEURL ?>/controller/ComprovanteController.php?action=save" 
            enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label" for="txtTitulo">Título:</label>
                    <input class="form-control" type="text" id="txtTitulo" name="titulo" 
                        maxlength="70" placeholder="Informe o título do comprovante"
                        value="<?php echo (isset($dados["comprovante"]) ? $dados["comprovante"]->getTitulo() : ''); ?>" />
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="txtHoras">Quantidade de horas: </label>
                    <input class="form-control" type="number" id="txtHoras" name="horas" 
                        maxlength="15" placeholder="Informe a quantidade de horas que o certificado valida"
                        value="<?php echo (isset($dados["comprovante"]) ? $dados["comprovante"]->getHoras() : ''); ?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="selAtiv">Tipo da atividade:</label>
                    <select class="form-select" name="selAtiv" id="selAtiv">
                        <option value="">Selecione o tipo</option>
                        <?php foreach($dados["cursoAtivs"] as $tipo): ?>
                            <option value="<?= $tipo->getId(); ?>" 
                                <?php 
                                    if(isset($dados["comprovante"]) && $dados["comprovante"]->getCursoAtiv() !== null &&
                                    $dados["comprovante"]->getCursoAtiv()->getId() == $tipo->getId()) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $tipo->getTipoAtiv()->getNomeAtiv(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtArq">Arquivo do comprovante: </label>
                    <input class="form-control" type="file" id="txtArq" name="arquivo" 
                        value="<?php echo (isset($dados["comprovante"]) ? $dados["comprovante"]->getArquivo() : ''); ?>"/>
                </div>
                
                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['idComp'] ?>" />

                <!-- Alteração: Agrupar botões lado a lado -->
                <div class="button-group mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                    <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/HomeController.php?action=home">Voltar</a>
                </div>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

   
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
