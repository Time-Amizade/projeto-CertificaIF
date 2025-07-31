<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class HomeController extends Controller {

    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        //Verificar se o usuário está logado
        if(! $this->usuarioEstaLogado())
            return;

        $this->usuarioDAO = new UsuarioDAO();

        //Tratar a ação solicitada no parâmetro "action"
        $this->handleAction();
    }

    protected function home() {
        $dados = array();
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL])) {
            if ($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR) {
                $dados['usuarios'] = $this->usuarioDAO->findByFilters('PENDENTE', null, 'COORDENADOR');
            } else if ($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::COORDENADOR) {
                $dados['usuarios'] = $this->usuarioDAO->findByFilters('PENDENTE', $_SESSION[SESSAO_USUARIO_CURSO], 'ALUNO');
            }
        }
        $this->loadView("home/home.php", $dados);
    }
    
}

//Criar o objeto do controller
new HomeController();