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
                    exit;
                    //$this->compDao->update($comprovante);
                
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

    protected function updateCampo(){
        $id = $_POST['id'];
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];

        $this->compDao->updateCampo($id, $campo, $valor);
    }

    protected function cancel(){
        $id = $_GET['id'];
        $this->compDao->cancelById($id);

        header("location: " . BASEURL . "/controller/HomeController.php?action=home");
    }

    protected function evaluate(){
        $id = $_GET['id'];
        $dados['comprovante'] = $this->compDao->findById($id);
        $dados['aluno'] = $this->usuarioDao->findById($dados['comprovante']->getUsuario()->getId());
        $dados['comps'] = $this->compDao->listByIdFilter($dados['aluno']->getId(), ComprovanteStatus::RECUSADO, ComprovanteStatus::APROVADO);
        $dados['cursoAtiv'] = $this->cursoAtivDao->findById($dados['comprovante']->getCursoAtiv()->getId());
        $dados['ativs'] = $this->cursoAtivDao->listByCurso($_SESSION[SESSAO_USUARIO_CURSO]);

        $this->loadView("comprovante/avaliar.php", $dados);
    }

    protected function approve(){
        $id = $_GET['id'];
        $this->compDao->approveById($id);

        header("location: " . BASEURL . "/controller/HomeController.php?action=home");
    }

    protected function refuse(){
        $id = $_GET['id'];
        $this->compDao->refuseById($id);

        header("location: " . BASEURL . "/controller/HomeController.php?action=home");
    }
}

new ComprovanteController();
?>