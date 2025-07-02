<?php 
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Atividades do curso: <?= $dados['curso']->getNomeCurso(); ?></h3> 

<div class="container">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success" 
                href="<?= BASEURL ?>/controller/CursoAtivController.php?action=create">
                Inserir</a>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabUsuarios" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Curso</th>
                        <th>Carga Horária Mínima</th>
                        <th>Alterar</th>
                        <th>Atividades</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados['lista'] as $ativ): ?>
                        <tr>
                            <td><?php echo $ativ->getId(); ?></td>
                            <td><?php echo $ativ->getTipoAtiv()->getNomeAtiv();?></td> 
                            <td><?= $ativ->getCargaHorariaMax(); ?></td>
                            <td><?= $ativ->getEquivalencia(); ?></td>
                            <td><a class="btn btn-primary" 
                                href="<?= BASEURL ?>/controller/CursoController.php?action=edit&id=<?= $curso->getId() ?>">
                                Alterar</a> 
                            </td>
                            <td><a class="btn btn-success"
                                href="<?= BASEURL ?>/controller/CursoAtivController.php?action=list&id=<?= $curso->getId() ?>">
                                Visualizar</a> 
                            </td> 
                            <td><a class="btn btn-danger"
                                onclick="return confirm('Confirma a exclusão do curso?');"
                                href="<?= BASEURL ?>/controller/CursoController.php?action=delete&id=<?= $curso->getId() ?>">
                                Excluir</a> 
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>