<?php

require_once(__DIR__.'/../include/header.php');
require_once(__DIR__.'/../include/menu.php');

if(isset($dados['comprovante'])) {
    $comprovante = $dados['comprovante'];
    $aluno = $dados['aluno'];
    $cursoAtiv = $dados['cursoAtiv'];
} else {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Comprovante não encontrado.</div></div>";
    require_once(__DIR__.'/../include/footer.php');
    exit;
}
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/sidebar.css">
<div class="expand-button-box">
    <div class="expand-button-content">
        <div class="expand-label">🛈</div>

        <div class="expand-details">
            <h6 class="text-center mb-3">Normas do PPC</h6>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Atividade</th>
                            <th>Equivalência</th>
                            <th>Limite</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados['ativs'] as $ativ): ?>
                            <tr>
                                <td><?= $ativ->getCodigo(); ?></td>
                                <td><?= $ativ->getTipoAtiv()?->getNomeAtiv() ?? 'Não informado'; ?></td>
                                <td><?= $ativ->getEquivalencia() ?? 'N/A'; ?></td>
                                <td><?= $ativ->getCargaHorariaMax(); ?>h</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <h2 class="text-center">Informações do comprovante</h2>
    <hr>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?= $comprovante->getTitulo(); ?></h4>
            <p class="card-text"><strong>Aluno:</strong> <?= $aluno->getNome(); ?></p>
            <p class="card-text"><strong>Horas Requeridas:</strong> <?= $comprovante->getHoras();?>horas</p>
            <p class="card-text"><strong>Artigo PPC:</strong> <?= $cursoAtiv->getTipoAtiv()->getNomeAtiv();?></p>
            <?php if ($comprovante->getComentario()): ?>
                <p class="card-text"><strong>Comentário:</strong> <?= $comprovante->getComentario(); ?></p>
            <?php endif; ?>
            <a href="<?= BASEURL_ARQUIVOS ?>/<?= $comprovante->getArquivo(); ?>" target="_blank" class="btn btn-info">Ver Arquivo</a>
            <div class="mt-3">
                <a href="<?= BASEURL ?>/controller/ComprovanteController.php?action=approve&id=<?= $comprovante->getId(); ?>" class="btn btn-success">Aprovar</a>
                <a href="<?= BASEURL ?>/controller/ComprovanteController.php?action=refuse&id=<?= $comprovante->getId(); ?>" class="btn btn-danger">Recusar</a>
                <a href="<?= BASEURL ?>/controller/HomeController.php?action=home" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</div>


<?php 

require_once(__DIR__ . "/../include/footer.php");

?>