<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];

$isAdmin = false;
if(isset($_SESSION[SESSAO_USUARIO_PAPEL]) 
        && $_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioPapel::ADMINISTRADOR)
    $isAdmin = true; 

?>
<nav class="navbar navbar-expand-md bg-light px-3 mb-3">
    <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse" data-bs-target="#navSite">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navSite">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= HOME_PAGE ?>">Home</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                    data-bs-toggle="dropdown">
                    Cadastros
                </a>

                <div class="dropdown-menu">
                    <?php if($isAdmin): ?>
                        <a class="dropdown-item"
                            href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="#">Outro cadastro</a>
                </div>
            </li>

        </ul>

        <ul class="navbar-nav ms-auto mr-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarUsuario"
                    data-bs-toggle="dropdown">
                    <?= $nome ?>
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item"
                        href="<?= BASEURL . '/controller/PerfilController.php?action=view' ?>">Perfil</a>
                    <a class="dropdown-item" href="<?= LOGOUT_PAGE ?>">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>