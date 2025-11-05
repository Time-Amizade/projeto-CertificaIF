<?php 
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");

class LoginController extends Controller {

    private LoginService $loginService;
    private UsuarioService $usuarioService;
    private UsuarioDAO $usuarioDao;

    public function __construct() {
        $this->loginService = new LoginService();
        $this->usuarioService = new UsuarioService();
        $this->usuarioDao = new UsuarioDAO();
        
        $this->handleAction();
    }

    protected function login() {
        $this->loadView("login/login.php", []);
    }

    /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logon() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;

        //Validar os campos
        $erros = $this->loginService->validarCampos($email, $senha);
        if(empty($erros)) {
            //Valida o login a partir do banco de dados
            
            $usuario = $this->usuarioDao->findByEmailSenha($email, $senha);

            if(is_object($usuario)) {
                //Se encontrou o usuário, salva a sessão e redireciona para a HOME do sistema
                $this->loginService->salvarUsuarioSessao($usuario);

                header("location: " . HOME_PAGE);
                exit;
            } else if($usuario === 'PENDENTE'){
                array_push($erros, 'O usuário ainda não foi aceito');
            } else {
                $erros = ["Email ou senha informados são inválidos!"];
            }
        }

        //Se há erros, volta para o formulário            
        $msg = implode("<br>", $erros);
        $dados["email"] = $email;
        $dados["senha"] = $senha;

        $this->loadView("login/login.php", $dados, $msg);
    }

     /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logout() {
        $this->loginService->removerUsuarioSessao();

        $this->loadView("login/login.php", [], "", "Usuário deslogado com suscesso!");
    }

    protected function changePassForm(){
        $this->loadView("login/passwordForm.php", []);
    }

    protected function changePass(){
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
        $senha = isset($_POST['senha']) ? $_POST['senha'] : null;
        $confSenha = isset($_POST['conf_senha']) ? $_POST['conf_senha'] : null;

        $erros = $this->usuarioService->ValidarMudarSenha($cpf, $confSenha, $senha);
        if ($cpf && empty($erros)) { 
            $usuario = $this->usuarioDao->findByCPF($cpf);
            if (!$usuario) {
                array_push($erros, "Nenhum usuário foi encontrado com o CPF informado!");
            }
        }
        
        if(empty($erros)){
            $this->usuarioDao->changePassword($cpf, $senha);
            header("location: ". HOME_PAGE);
            exit;
        }

        $msg = implode("<br>", $erros);
        $dados["cpf"] = $cpf;
        $this->loadView("login/passwordForm.php", $dados, $msg);
    }

}
new LoginController();