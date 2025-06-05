<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/Usuariofuncao.php");

class UsuarioController extends Controller {

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(! $this->usuarioEstaLogado())
            return;

        //Restringir o acesso apenas para administradores
        if(! $this->usuarioLogadoFuncaoAdmin()) {
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

    protected function create() {
        $dados['id'] = 0;
        $dados['papeis'] = Usuariofuncao::getAllAsArray();

        $this->loadView("usuario/form.php", $dados);
    }

    protected function edit() {
        //Busca o usuário na base pelo ID    
        $usuario = $this->findUsuarioById();
        if($usuario) {
            $dados['id'] = $usuario->getId();
            $usuario->setSenha("");
            $dados["usuario"] = $usuario;

            $dados['papeis'] = Usuariofuncao::getAllAsArray();
            
            $this->loadView("usuario/form.php", $dados);
        } else
            $this->list("Usuário não encontrado!");
    }

    protected function save() {
        //Capturar os dados do formulário
        $id = $_POST['id'];
        $nome = trim($_POST['nome']) != "" ? trim($_POST['nome']) : NULL;
        $email = trim($_POST['email']) != "" ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) != "" ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) != "" ? trim($_POST['conf_senha']) : NULL;
        $funcao = $_POST['funcao'];

        //Criar o objeto Usuario
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setFuncao($funcao);

        //Validar os dados (camada service)
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);
        if(! $erros) {
            //Inserir no Base de Dados
            try {
                if($usuario->getId() == 0)
                    $this->usuarioDao->insert($usuario);
                else
                    $this->usuarioDao->update($usuario);
                
                header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                exit;
            } catch(PDOException $e) {
                //Iserir erro no array
                array_push($erros, "Erro ao gravar no banco de dados!");
                //array_push($erros, $e->getMessage());
            }
        } 

        //Mostrar os erros
        $dados['id'] = $usuario->getId();
        $dados['papeis'] = UsuarioFuncao::getAllAsArray();
        $dados["usuario"] = $usuario;
        $dados['confSenha'] = $confSenha;

        $msgErro = implode("<br>", $erros);

        $this->loadView("usuario/form.php", $dados, $msgErro);
    }

    protected function delete() {
        //Busca o usuário na base pelo ID    
        $usuario = $this->findUsuarioById();
        
        if($usuario) {
            //Excluir
            $this->usuarioDao->deleteById($usuario->getId());

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
            exit;
        } else {
            $this->list("Usuário não encontrado!");
        }
    }

    protected function listJson() {
        //Retornar uma lista de usuários em forma JSON
        $usuarios = $this->usuarioDao->list();
        $json = json_encode($usuarios);
        
        echo $json;

        //[{},{},{}]
    }

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