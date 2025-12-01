<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Usuários</h3>

<div class="container">
    <div class="row">
        
        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <div class="row">
    <?php foreach($dados['lista'] as $usu): ?>
        <div class="col-md-4 mb-4">
            <div class="card text-center shadow">

                <img src="<?= BASEURL_ARQUIVOS . "/" . $usu->getFotoPerfil()?>" class="card-img-top" style="height: 200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title"><?= $usu->getNome(); ?></h5>

                    <a class="btn btn-primary btn-sm" href="<?= BASEURL ?>/controller/PerfilController.php?action=view&id=<?= $usu->getId() ?>">
                        Visualizar
                    </a>

                    <?php if($usu->getStatus() === UsuarioStatus::ATIVO): ?>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('Confirma a desativação do usuário?');" href="<?= BASEURL ?>/controller/UsuarioController.php?action=deactivate&id=<?= $usu->getId() ?>">
                            Desativar
                        </a>
                    <?php else: ?>
                        <a class="btn btn-success btn-sm" onclick="return confirm('Confirma a ativação do usuário?');" href="<?= BASEURL ?>/controller/UsuarioController.php?action=activate&id=<?= $usu->getId() ?>">
                            Ativar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>