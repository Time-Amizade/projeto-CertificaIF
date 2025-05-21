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

    protected function save() {
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
                    
                    header("location: " . BASEURL . "/controller/PerfilController.php?action=view");
                    exit;
                } catch(PDOException $e) {
                    array_push($erros, "Não foi possível salvar a imagem na base de dados!");
                    array_push($erros, $e->getMessage());
                }
            } else {
                array_push($erros, "Não foi possível salvar o arquivo da imagem!");
            }
        }

        $idUsuarioLogado = $this->getIdUsuarioLogado();
        $usuario = $this->usuarioDao->findById($idUsuarioLogado);
        $dados['usuario'] = $usuario;

        $msgErro = implode("<br>", $erros);

        $this->loadView("perfil/perfil.php", $dados, $msgErro); 
    }

}

new PerfilController();