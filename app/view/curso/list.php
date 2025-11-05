<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
$pagina = 'cursoList';
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/list.css">
<h3 class="text-center">Cursos</h3>

<div class="container">
    <div class="row">
        <div class="col-6">
            <a class="btn btn-success" 
                href="<?= BASEURL ?>/controller/CursoController.php?action=create">
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
                    <?php foreach($dados['lista'] as $curso): ?>
                        <tr>
                            <td><?php echo $curso->getId(); ?></td>
                            <td><?= $curso->getNomeCurso(); ?></td>
                            <td><?= $curso->getCargaHorariaAtivComplement(); ?></td>
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