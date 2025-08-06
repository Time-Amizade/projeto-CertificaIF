<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/home.css">

<h3 class="text-center">Página inicial do sistema</h3>

<div class='container' id='listaDados'>

<!--
  <?php if($_SESSION[SESSAO_USUARIO_PAPEL] == 'ADMINISTRADOR'): ?>


    <?php foreach($dados['usuarios'] as $usuario): ?>
        <div class='card'  style="width: 18rem;">
          <h5 class='card-title text-center'><?= $usuario->getNome()?></h5>
          <h6 class='card-subtitle text-center'><?= $usuario->getEmail() ?></h6>
          <ul class='list-group list-group-flush'>
            <li class='list-group-item'><?=$usuario->getCursoid()->getNomeCurso()?></li>
            <li class='list-group-item'><?=$usuario->getCpf()?></li>
          </ul>
          <div class='card-footer'>
            <button class="btn btn-succes mt-3"><a href="<?= BASEURL . '/controller/CadastroController.php?action=confirm&id='.$usuario->getId()?>">Cadastrar</a></button>
          </div>
        </div>
        <br> 
    <?php endforeach; ?>

  <?php elseif($_SESSION[SESSAO_USUARIO_PAPEL] == 'COORDENADOR'): ?>

    <?php foreach($dados['usuarios'] as $usuario): ?>
        <p><?= "O usuário : " . $usuario->getNome() .", tem o seguinte código de matrícula: ". $usuario->getCodigoMatricula() ?> </p>
        <br>
    <?php endforeach; ?>

  <?php else: ?>
    <p>Lista de comprovante</p>
  <?php endif; ?>
!-->
</div>
  <a href="<?= BASEURL . '/controller/CursoController.php?action=create'?>">link para</a>
    
<script src="<?= BASEURL ?>/view/js/home_ajax.js"> </script>
<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
