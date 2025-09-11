<?php
#Nome do arquivo: perfil/perfil.php
#Objetivo: interface para perfil dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
$papel;
if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR){
    $papel = "admin";
} else if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::COORDENADOR){
    $papel = "coordenador";
}else if($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ALUNO){
    $papel = "aluno";
}
        
?>



<div class="container"> 

     <div class="row col-8 justify-content-center" >

        <div class="row">

            <div class="col-6">
                
                <h3 class="text-center">
                    Perfil
                </h3>
                <div class="row mt-5">
                        <div class="col-6">
                        <?php if($dados['usuario']->getFotoPerfil()): ?>
                                <img src="<?= BASEURL_ARQUIVOS . '/' . $dados['usuario']->getFotoPerfil() ?>"
                                    height="300" alt="Foto de perfil">
                            <?php else: ?>
                                <img src="<?= BASEURL ?>/../arquivos/padrao.png"
                                    height="300" alt="Foto padrão">
                        <?php endif; ?>

            
                        
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Nome:</span>
                        <span><?= $dados['usuario']->getNome() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Email:</span>
                        <span><?= $dados['usuario']->getEmail() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Data de Nascimento:</span>
                        <span><?= $dados['usuario']->getDataNascimento() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">CPF:</span>
                        <span><?= $dados['usuario']->getCPF() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Telefone:</span>
                        <span><?= $dados['usuario']->getTelefone() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Endereço:</span>
                        <span><?= $dados['usuario']->getEndereco() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Data de Nascimento:</span>
                        <span><?= $dados['usuario']->getDataNascimento() ?></span>
                    </div>

                    <div class="col-12 mb-2">
                        <span class="fw-bold">Função:</span>
                        <span><?= $dados['usuario']->getFuncao() ?></span>
                    </div>
                    <?php if($papel != "admin"): ?>  
                        <div class="col-12 mb-2">
                            <span class="fw-bold">Curso:</span>
                            <span><?= $dados['usuario']->getCursoId()->getNomeCurso() ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if($papel == "aluno"): ?>
                        <div class="col-12 mb-2">
                            <span class="fw-bold">Horas Validadas:</span>
                        <span><?= $dados['usuario']->getHorasValidadas() ?? 0 ?></span>
                
                        </div>
                    <?php endif; ?>

                    <?php if($papel == "aluno"): ?>         
                        <div class="col-12 mb-2">
                            <span class="fw-bold">Código de Matricula:</span>
                            <span><?= $dados['usuario']->getCodigoMatricula() ?></span>
                        </div>
                    <?php endif; ?>   


                </div>
                    
                
            </div>  
            

        </div>
        

       <div class="row" style="margin-top: 30px;">
            <div class="col-12 d-flex gap-2">
                <a class="btn btn-secondary" href="<?= HOME_PAGE ?>">Voltar</a>
                <a class="btn btn-success" href="<?= BASEURL ?>/controller/PerfilController.php?action=edit&id=<?= $dados['usuario']->getId() ?>">Editar</a>
            </div>
        </div>


    </div>  

    <<div class="row col-8 justify-content-center">
  <h5>Progresso das Horas</h5>

  <svg class="grafico" viewBox="0 0 36 36" width="180" height="180">
    <!-- fundo vermelho (faltantes) -->
    <circle class="fundo" r="16" cx="18" cy="18" stroke="#e53935" stroke-width="32" fill="none" transform="rotate(-90 18 18)"></circle>

    <!-- valor verde (validadas) -->
    <circle class="valor" r="16" cx="18" cy="18" stroke="#4caf50" stroke-width="32" fill="none" transform="rotate(-90 18 18)"></circle>

    <!-- texto central -->
    <text class="label" x="18" y="18" font-size="8" text-anchor="middle" dominant-baseline="middle" fill="#333">0%</text>
  </svg>
</div>

<script>
  // valores de exemplo (substitua pelos valores do PHP)
  const horasValidadas = 12;
  const horasTotais = 48;

  const svg = document.querySelector('.grafico');
  const valor = svg.querySelector('.valor');
  const texto = svg.querySelector('.label');

  const r = 16; // raio do círculo
  const circ = 2 * Math.PI * r; // circunferência

  // calcular fração (0 a 1)
  const frac = horasTotais > 0 ? horasValidadas / horasTotais : 0;

  // comprimento da fatia verde
  const dash = frac * circ;
  const gap = circ - dash;

  // aplicar no SVG
  valor.setAttribute('stroke-dasharray', `${dash} ${gap}`);
  valor.setAttribute('stroke-dashoffset', 0);

  // atualizar texto central
  texto.textContent = `${Math.round(frac * 100)}%`;
</script>



<?php  
require_once(__DIR__ . "/../include/footer.php");
?>