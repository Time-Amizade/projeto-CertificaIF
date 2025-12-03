<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];

$isAdmin = false;
if(isset($_SESSION[SESSAO_USUARIO_PAPEL]) 
        && $_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR)
    $isAdmin = true; 

?>
<nav class="navbar navbar-expand-md navbar-dark px-3 mb-3" style="background-color: rgb(14, 76, 16);">
    <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse" data-bs-target="#navSite">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navSite">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= HOME_PAGE ?>">Home</a>
            </li>

            <?php if($isAdmin): ?>
                <!-- <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL . '/controller/CursoController.php?action=list'?>">Cursos</a>
                </li> -->
                <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL . '/controller/UsuarioController.php?action=list'?>">Coordenadores</a>
                </li>
            <?php endif; ?>

            <?php if($_SESSION[SESSAO_USUARIO_PAPEL] === UsuarioFuncao::COORDENADOR): ?>
                <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL . '/controller/UsuarioController.php?action=list'?>">Alunos</a>
                </li>
            <?php endif; ?>


            <?php if($_SESSION[SESSAO_USUARIO_PAPEL] === UsuarioFuncao::ALUNO): ?>
                <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL . '/controller/ComprovanteController.php?action=create' ?>">Comprovantes</a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="position-absolute top-50 start-50 translate-middle d-flex align-items-center" >
            <img src="<?= BASEURL . '/view/img/LogoMenu.png'?>" style="height: 55px; width: 130px;">
        </div>


        <ul class="navbar-nav ms-auto mr-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarUsuario"
                    data-bs-toggle="dropdown">
                    <?= $nome ?>
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item"
                        href="<?= BASEURL . '/controller/PerfilController.php?action=view'?>">Perfil</a>
                    <a class="dropdown-item" href="<?= LOGOUT_PAGE ?>">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>