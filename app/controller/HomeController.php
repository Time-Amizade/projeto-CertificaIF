<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__. "/../dao/ComprovanteDAO.php");

class HomeController extends Controller {

    private UsuarioDAO $usuarioDao;
    private ComprovanteDAO $comprovanteDao;

    public function __construct() {
        //Verificar se o usuário está logado
        if(! $this->usuarioEstaLogado())
            return;

        $this->usuarioDao = new UsuarioDAO();
        $this->comprovanteDao = new ComprovanteDAO();

        //Tratar a ação solicitada no parâmetro "action"
        $this->handleAction();
    }

    protected function home() {
        $dados = array();

        /*
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL])) {
            if ($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR) {
                $dados['usuarios'] = $this->usuarioDao->findByFilters('PENDENTE', null, 'COORDENADOR');
            } else if ($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::COORDENADOR) {
                $dados['usuarios'] = $this->usuarioDao->findByFilters('PENDENTE', $_SESSION[SESSAO_USUARIO_CURSO], 'ALUNO');
            }else{
                $dados['comps'] = $this->comprovanteDao->list($_SESSION[SESSAO_USUARIO_ID]);
            }
        }
    */
        $this->loadView("home/home.php", $dados);
    }
    
}

//Criar o objeto do controller
new HomeController();