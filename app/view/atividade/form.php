<?php
#Nome do arquivo: curso/form.php
#Objetivo: interface para cadastros os cursos do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    atividade 
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmCurso" method="POST" action="<?= BASEURL ?>/controller/CursoAtivController.php?action=save" >
                
                <div class="mb-3">
                    <label class="form-label" for="txtCodigo">Código:</label>
                    <input class="form-control" type="number" id="txtCodigo" name="codigo" 
                        maxlength="70" placeholder="Informe o código da atividade"
                        value="<?php echo (isset($dados["ativ"]) ? $dados["ativ"]->getCodigo() : ''); ?>" />
                </div>
            
                <div class="mb-3">
                    <label class="form-label" for="selAtiv">Tipo da atividade:</label>
                    <select class="form-select" name="ativ" id="selAtiv">
                        <option value="">Selecione o tipo</option>
                        <?php foreach($dados["listaTipo"] as $tipo): ?>
                            <option value="<?= $tipo->getId(); ?>" 
                                <?php 
                                    if(isset($dados["ativ"]) && $dados["ativ"]->getTipoAtiv()->getId() == $tipo->getId()) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $tipo->getNomeAtiv(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtCargaHorariaMax">Carga Horária Máxima:</label>
                    <input class="form-control" type="number" id="txtNomeCurso" name="cargaHorariaMax" 
                        maxlength="70" placeholder="Informe a carga horária máxima da atividade"
                        value="<?php echo (isset($dados["ativ"]) ? $dados["ativ"]->getCargaHorariaMax() : ''); ?>" />
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="txtEquivalencia">Equivalência:</label>
                    <input class="form-control" type="text" id="txtEquivalencia" name="equivalencia" 
                        maxlength="45" placeholder="Informe a equivalência (1hr = 1hr)"
                        value="<?php echo (isset($dados["ativ"]) ? $dados["ativ"]->getEquivalencia() : ''); ?>"/>
                </div>



                
                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />
                <?php if(isset($dados['idCurso'])): ?>
                <input type="hidden" id="hddId2" name="idCurso" 
                    value="<?= $dados['idCurso']; ?>" />
                <?php endif; ?>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                </div>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>
        
    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
            <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/CursoAtivController.php?action=list&id=<?=$dados['idCurso']?>">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>