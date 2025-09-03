<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");

class PerfilController extends Controller {

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;
    private ArquivoService $arquivoService;

    public function __construct() {
        if(! $this->usuarioEstaLogado())
            return;

        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();
        $this->arquivoService = new ArquivoService();

        $this->handleAction();    
    }

    protected function view() {
        $idUsuarioLogado = $this->getIdUsuarioLogado();
        $usuario = $this->usuarioDao->findById($idUsuarioLogado);
        $dados['usuario'] = $usuario;

        $this->loadView("perfil/perfil.php", $dados);    
    }

    protected function update() {
        $foto = $_FILES["foto"];
        $fotoAnterior = $_POST['fotoAnterior'];
        
        //Validar se o usuário mandou a foto de perfil
        $erros = $this->usuarioService->validarFotoPerfil($foto);
        if(! $erros) {
            //1- Salvar a foto em um arquivo
            $nomeArquivo = $this->arquivoService->salvarArquivo($foto);
            
            if($nomeArquivo) {
                //2- Atualizar o registro do usuário com o nome do arquivo da foto
                $usuario = new Usuario();
                $usuario->setFotoPerfil($nomeArquivo);
                $usuario->setId($this->getIdUsuarioLogado());
                
                try {
                    $this->usuarioDao->updateFotoPerfil($usuario);

                    //3- Excluir o arquivo
                    $this->arquivoService->removerArquivo($fotoAnterior);
                    
                    // header("location: " . BASEURL . "/controller/PerfilController.php?action=view");
                    // exit;
                } catch(PDOException $e) {
                    array_push($erros, "Não foi possível salvar a imagem na base de dados!");
                    array_push($erros, $e->getMessage());
                }
            } else {
                array_push($erros, "Não foi possível salvar o arquivo da imagem!");
            }
        }
        $id = $_POST['id'];
        $nome = trim($_POST['nome']) != "" ? trim($_POST['nome']) : NULL;
        $dataNascimento = trim($_POST['dataNascimento']) != "" ? trim($_POST['dataNascimento']) : NULL;
        $cpf = trim($_POST['cpf']) != "" ? trim($_POST['cpf']) : NULL;
        $email = trim($_POST['email']) != "" ? trim($_POST['email']) : NULL;
        $telefone = trim($_POST['telefone']) != "" ? trim($_POST['telefone']) : NULL;
        $endereco = trim($_POST['endereco']) != "" ? trim($_POST['endereco']) : NULL;
        $senha = trim($_POST['senha'] ?? '') ?: null;
        $confSenha = trim($_POST['confSenha'] ?? '') ?: null;

        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setDataNascimento($dataNascimento);
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setTelefone($telefone);
        $usuario->setEndereco($endereco);
        if($senha){
        $usuario->setSenha($senha);
        }


         $erros = $this->usuarioService->ValidarEdicao($usuario, $confSenha, $senha); 
        

        if($erros){
            $msg = implode("<br>", $erros);
            $usu = $this->usuarioDao->findById($usuario->getId());
            $usuario->setFotoPerfil($usu->getFotoPerfil());
            // $usuario->setId($usu->getId());
            $dados["usuario"] = $usuario;
            $this->loadView("perfil/editar.php", $dados,$msg);
            exit;
        }

        $this->usuarioDao->updatePerfil($usuario);

        header("location: " . BASEURL . "/controller/PerfilController.php?action=view"); 
     
    }

    protected function edit() {
        //Busca o usuário na base pelo ID    
        $id = $_GET["id"];
        $usuario = $this->findUsuarioById($id);

        if($usuario) {
            $dados['id'] = $usuario->getId();
            // $usuario->setSenha("");
            $dados["usuario"] = $usuario;

            $dados['papeis'] = Usuariofuncao::getAllAsArray();
            
            $this->loadView("perfil/editar.php", $dados);
        } else
            exit;
            //$this->list("Usuário não encontrado!");
    }

    private function findUsuarioById() {
        $id = 0;
        if(isset($_GET["id"]))
            $id = $_GET["id"];

        //Busca o usuário na base pelo ID    
        return $this->usuarioDao->findById($id);
    }

}

new PerfilController();