<?php
#Nome do arquivo: curso/form.php
#Objetivo: interface para cadastros os cursos do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    Curso
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmCurso" method="POST" action="<?= BASEURL ?>/controller/CursoController.php?action=save" >
                <div class="mb-3">
                    <label class="form-label" for="txtNomeCurso">Nome do Curso:</label>
                    <input class="form-control" type="text" id="txtNomeCurso" name="nomeCurso" 
                        maxlength="70" placeholder="Informe o nome do curso"
                        value="<?php echo (isset($dados["curso"]) ? $dados["curso"]->getNomeCurso() : ''); ?>" />
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="txtCargaHoraria">Carga horária mínima:</label>
                    <input class="form-control" type="text" id="txtCargaHoraria" name="CargaHoraria" 
                        maxlength="15" placeholder="Informe a carga horaria mínima: "
                        value="<?php echo (isset($dados["curso"]) ? $dados["curso"]->getCargaHorariaAtivComplement() : ''); ?>"/>
                </div>
  
                <hr>
                <hr>

                <div class="mb-3">
                    <label class="form-label" for="selPapel">Papel:</label>
                    <select class="form-select" name="papel" id="selPapel">
                        <option value="">Selecione o papel</option>
                        <?php foreach($dados["papeis"] as $papel): ?>
                            <option value="<?= $papel ?>" 
                                <?php 
                                    if(isset($dados["curso"]) && $dados["curso"]->getPapel() == $papel) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $papel ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
        <a class="btn btn-secondary" 
                href="<?= BASEURL ?>/controller/CursoController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>