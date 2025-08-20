<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/UsuarioFuncao.php");

class UsuarioController extends Controller {

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(!$this->usuarioEstaLogado())
            return;

        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoCoord()) {
            echo "Acesso negado!";
            exit;
        }

        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();

        $this->handleAction();
    }
    
    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $dados["lista"] = $this->usuarioDao->list();
        
        $this->loadView("usuario/list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function confirm(){
        $id = $_GET['id'];
        $this->usuarioDao->confirmSignUp($id);

        header("location: " . BASEURL . "/controller/HomeController.php?action=home");
    }

    protected function refuse(){
        $id = $_GET['id'];
        $this->usuarioDao->deleteById($id);

        header("location: " . BASEURL . "/controller/HomeController.php?action=home");
    }

    // protected function edit() {
    //     //Busca o usuário na base pelo ID    
    //     $usuario = $this->findUsuarioById();
    //     if($usuario) {
    //         $dados['id'] = $usuario->getId();
    //         $usuario->setSenha("");
    //         $dados["usuario"] = $usuario;

    //         $dados['papeis'] = Usuariofuncao::getAllAsArray();
            
    //         $this->loadView("usuario/form.php", $dados);
    //     } else
    //         $this->list("Usuário não encontrado!");
    // }

    // protected function delete() {
    //     //Busca o usuário na base pelo ID    
    //     $usuario = $this->findUsuarioById();
        
    //     if($usuario) {
    //         //Excluir
    //         $this->usuarioDao->deleteById($usuario->getId());

    //         header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
    //         exit;
    //     } else {
    //         $this->list("Usuário não encontrado!");
    //     }
    // }


    private function findUsuarioById() {
        $id = 0;
        if(isset($_GET["id"]))
            $id = $_GET["id"];

        //Busca o usuário na base pelo ID    
        return $this->usuarioDao->findById($id);
    }

    

}


#Criar objeto da classe para assim executar o construtor
new UsuarioController();