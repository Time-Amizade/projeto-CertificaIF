<?php

require_once(__DIR__.'/../include/header.php');
require_once(__DIR__.'/../include/menu.php');

if(isset($dados['comprovante'])) {
    $comprovante = $dados['comprovante'];
    $aluno = $dados['aluno'];
    $cursoAtiv = $dados['cursoAtiv'];
    $comps = $dados['comps'];
} else {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Comprovante não encontrado.</div></div>";
    require_once(__DIR__.'/../include/footer.php');
    exit;
}

?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/sidebar.css">

<div class="expand-button-box right-box">
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

<div class="expand-button-box left-box">
    <div class="expand-button-content green-panel">
        <div class="expand-label">🛈</div>
        <div class="expand-details">
            <h6 class="text-center mb-3 text-white">Comprovantes Enviados Anteriormente</h6>
            <div class="scroll-container">

                <?php if (!empty($comps)): ?>
                    <?php foreach ($comps as $comp): ?>
                        <div class="comprovante-card mb-3">
                            <div class="comprovante-info">
                                <p><i class="bi bi-code-slash"></i> <strong>Código da Atividade:</strong> <?= $comp->getCursoAtiv()->getCodigo(); ?></p>
                                <p><i class="bi bi-file-earmark-text"></i> <strong>Título:</strong> <?= $comp->getTitulo() ?? 'Sem nome'; ?></p>
                                <p><i class="bi bi-file-earmark-text"></i> <strong>Status:</strong> <?= $comp->getStatus() ?? 'Sem nome'; ?></p>
                                <?php if ($comp->getComentario()): ?>
                                    <p><i class="bi bi-file-earmark-text"></i> <strong>Comentário:</strong> <?= $comp->getComentario(); ?></p>
                                <?php endif; ?>
                            </div>
                            <a href="<?= BASEURL_ARQUIVOS ?>/<?= $comp->getArquivo(); ?>" target="_blank" class="btn btn-light btn-sm mt-2">
                                <i class="bi bi-box-arrow-up-right"></i> Ver Arquivo
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white text-center">Nenhum comprovante enviado anteriormente.</p>
                <?php endif; ?>
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
            <p>
                <strong>Horas Requeridas:</strong> 
                <span id="horas" data-id=<?= $comprovante->getId(); ?> data-campo="horas" onclick="ativarEdicao(this)"><?= $comprovante->getHoras();?> horas</span>
            </p>

            <p class="card-text"><strong>Artigo PPC: <?= $cursoAtiv->getCodigo() . ')';?> </strong> <?= $cursoAtiv->getTipoAtiv()->getNomeAtiv();?></p>
            <?php if ($comprovante->getComentario()): ?>
                <p class="card-text"><strong>Comentário:</strong> <?= $comprovante->getComentario(); ?></p>
            <?php endif; ?>
            <a href="<?= BASEURL_ARQUIVOS ?>/<?= $comprovante->getArquivo(); ?>" target="_blank" class="btn btn-info">Ver Arquivo</a>
            <div class="mt-3">
                <a href="<?= BASEURL ?>/controller/ComprovanteController.php?action=approve&id=<?= $comprovante->getId(); ?>" class="btn btn-success">Aprovar</a>
                <a href="#" onclick="recusarComprovante(<?= $comprovante->getId(); ?>)" class="btn btn-danger">Recusar</a>
                <a href="<?= BASEURL ?>/controller/HomeController.php?action=home" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</div>

<script>
    const BASEURL = "<?= BASEURL ?>";
    function ativarEdicao(span) {
        let valorAtual = span.innerText.replace(" horas", "").trim();   
        let input = document.createElement("input");
        input.type = "number";
        input.value = valorAtual;
        input.style.width = "100px";

        span.replaceWith(input);
        input.focus();

        input.addEventListener("blur", function() {
            salvarEdicao(input, span, valorAtual);
        });

        input.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
            salvarEdicao(input, span, valorAtual);
            }
        });
    }

    function salvarEdicao(input, spanOriginal, valorAtual) {
        let novoValor = input.value.trim(); // remove espaços extras
        let id = spanOriginal.getAttribute("data-id");
        let campo = spanOriginal.getAttribute("data-campo");

        if (novoValor === "") {
            novoValor = valorAtual;
        }

        var xhttp = new XMLHttpRequest();
        var url = BASEURL + "/controller/ComprovanteController.php?action=updateCampo";
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {

                let novoSpan = spanOriginal.cloneNode();
                novoSpan.setAttribute("data-id", id);
                novoSpan.setAttribute("data-campo", campo);
                novoSpan.innerText = novoValor + " horas";
                novoSpan.onclick = function() { ativarEdicao(novoSpan); };

                input.replaceWith(novoSpan);
            }
        };

        xhttp.send("id=" + id + "&campo=" + campo + "&valor=" + encodeURIComponent(novoValor));
    }

    function recusarComprovante(id) {
        let comentario = prompt("Digite o motivo da recusa:");

        if (comentario === null || comentario.trim() === "") {
            alert("É obrigatório informar um comentário para recusar.");
            return;
        }

        window.location.href = BASEURL + "/controller/ComprovanteController.php?action=refuse&id=" + id + "&comentario=" + encodeURIComponent(comentario);
    }
</script>

<?php 

require_once(__DIR__ . "/../include/footer.php");

?>