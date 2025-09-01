<?php

require_once(__DIR__.'/Controller.php');
require_once(__DIR__.'/../dao/ComprovanteDAO.php');
require_once(__DIR__.'/../dao/UsuarioDAO.php');
require_once(__DIR__.'/../dao/CursoAtivDAO.php');
require_once(__DIR__.'/../service/ComprovanteService.php');
require_once(__DIR__.'/../service/ArquivoService.php');
require_once(__DIR__.'/../model/Comprovante.php');
require_once(__DIR__.'/../model/Usuario.php');
require_once(__DIR__.'/../model/CursoAtiv.php');


class ComprovanteController extends Controller{
    private ComprovanteDAO $compDao;
    private CursoAtivDAO $cursoAtivDao;
    private UsuarioDAO $usuarioDao;
    private ComprovanteService $compService;
    private ArquivoService $arqService;

    public function __construct(){
        if(!$this->usuarioEstaLogado())
            return;
        
        $this->cursoAtivDao = new CursoAtivDAO();
        $this->compDao = new ComprovanteDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->compService = new ComprovanteService();
        $this->arqService = new ArquivoService();
        
        $this->handleAction();
    }

    protected function create(){
        $dados['idComp'] = 0;
        $dados['cursoAtivs'] = $this->cursoAtivDao->listByCurso($_SESSION[SESSAO_USUARIO_CURSO]);
        $this->loadView("comprovante/form.php", $dados);
    }

    protected function save() {
        $id = $_POST['id'];
        $titulo = trim($_POST['titulo']) != "" ? trim($_POST['titulo']) : NULL;
        $horas = trim($_POST['horas']) != "" ? trim($_POST['horas']) : null;
        $arquivo = $_FILES['arquivo'];
        $cursoAtivId = $_POST['selAtiv'];

        $comprovante = new Comprovante();
        $comprovante->setId($id);
        $comprovante->setTitulo($titulo);
        $comprovante->setHoras($horas);

        
        $nomeArquivo = $this->arqService->salvarArquivo($arquivo);

        if($nomeArquivo){
            $comprovante->setArquivo($nomeArquivo);
        }

        $usuario = new Usuario();
        $usuario = $this->usuarioDao->findById($this->getIdUsuarioLogado());
        $comprovante->setUsuario($usuario);

        $cursoAtiv = new CursoAtiv();
        $cursoAtiv = $this->cursoAtivDao->findById($cursoAtivId);
        $comprovante->setCursoAtiv($cursoAtiv);

        $erros = $this->compService->validarDados($comprovante);
        if(!$erros){
            try{
                if($comprovante->getId() == 0)
                    $this->compDao->insert($comprovante);
                else
                    $this->compDao->update($comprovante);
                
                header("location: " . BASEURL . "/controller/HomeController.php?action=home");
                exit;
            } catch(PDOException $e) {
                //Iserir erro no array
                array_push($erros, "Erro ao gravar no banco de dados!");
                array_push($erros, $e->getMessage());
            }
        }
        //Mostrar os erros
        $dados['idComp'] = 0;
        $dados['cursoAtivs'] = $this->cursoAtivDao->listByCurso($_SESSION[SESSAO_USUARIO_CURSO]);
        $dados["comprovante"] = $comprovante;

        $msgErro = implode("<br>", $erros);

        $this->loadView("comprovante/form.php", $dados, $msgErro);

    }


    protected function cancel(){
        $id = $_GET['id'];
        $this->compDao->cancelById($id);

        header("location: " . BASEURL . "/controller/HomeController.php?action=home");
    }
}

new ComprovanteController();
?>