<?php
$pagina = "listUsuario";
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/listUsuario.css">

<div class="container mt-4">
    <h3 class="text-center mb-4 page-title text-light">Usuários</h3>

    <div class="row justify-content-center">
        <div class="col-10">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <?php foreach($dados['lista'] as $usu): ?>
            <div class="col-md-4">
                <div class="card user-card shadow-lg">

                    <div class="profile-img-wrapper">
                        <img src="<?= BASEURL_ARQUIVOS . "/" . $usu->getFotoPerfil()?>"
                             class="card-img-top profile-img">
                    </div>
                    <?= var_dump($usu->getCurso()) ?>
                    <div class="card-body text-center">
                        <h5 class="card-title text-light"><?= $usu->getNome(); ?></h5>
                        <h5 class="card-title text-light"><?= $usu->getCursoid()->getNomeCurso(); ?></h5>

                        <div class="d-flex justify-content-center gap-2 mt-3">

                            <a class="btn btn-view btn-sm" 
                               href="<?= BASEURL ?>/controller/PerfilController.php?action=view&id=<?= $usu->getId() ?>">
                                Visualizar
                            </a>

                            <?php if($usu->getStatus() === UsuarioStatus::ATIVO): ?>
                                <a class="btn btn-danger-custom btn-sm"
                                   onclick="return confirm('Confirma a desativação do usuário?');"
                                   href="<?= BASEURL ?>/controller/UsuarioController.php?action=deactivate&id=<?= $usu->getId() ?>">
                                    Desativar
                                </a>
                            <?php else: ?>
                                <a class="btn btn-success-custom btn-sm"
                                   onclick="return confirm('Confirma a ativação do usuário?');"
                                   href="<?= BASEURL ?>/controller/UsuarioController.php?action=activate&id=<?= $usu->getId() ?>">
                                    Ativar
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>
