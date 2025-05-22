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

        $dados["qtdUsuarios"] = $this->usuarioDAO->quantidadeUsuarios(); 

        $this->loadView("home/home.php", $dados);
    }
    
}

//Criar o objeto do controller
new HomeController();