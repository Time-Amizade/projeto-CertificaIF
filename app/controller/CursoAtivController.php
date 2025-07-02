<?php 

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoAtivDAO.php");
require_once(__DIR__ . "/../dao/TipoAtivDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../model/CursoAtiv.php");
require_once(__DIR__ . "/../model/Curso.php");
require_once(__DIR__ . "/../model/TipoAtiv.php");

class CursoAtivController extends Controller{

    private CursoAtivDAO $cursoAtivDao;
    private TipoAtivDAO $tipoAtivDao;
    private CursoDAO $cursoDao;
    //private CursoService $cursoService;

    public function __construct() {
        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoAdmin()) {
            echo "Acesso negado!";
            exit;
        }
        
        $this->cursoAtivDao = new CursoAtivDAO();
        $this->tipoAtivDao = new TipoAtivDAO();
        $this->cursoDao = new CursoDAO();
        //$this->cursoService = new CursoService();

        $this->handleAction();
    } 
    protected function list(string $msgErro = "", string $msgSucesso = ""){
        $curso = $this->findCursoById();
        if(! $curso) {
            echo "Sem curso!";
            exit;
        }

        $dados['curso'] = $curso;

        $dados["lista"] = $this->cursoAtivDao->listByCurso($curso->getId());

        $this->loadView("atividade/list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function findCursoById() : ?Curso{
        $id = 0;
        if(isset($_GET["id"]))
            $id = $_GET["id"];

        //Busca os cursos na base pelo ID    
        return $this->cursoDao->findById($id);
    }

    protected function create(){
        $dados['id'] = 0; 
        $dados['idCurso'] = $_GET['id'];
        $dados['listaTipo'] = $this->tipoAtivDao->list();
        
        $this->loadView("atividade/form.php", $dados);
    }


    protected function save(){
        
        $id = $_POST['id'];
        $idCurso = $_POST['idCurso'];
        $cargaHorariaMax = trim($_POST['cargaHorariaMax']) != "" ? trim($_POST['cargaHorariaMax']) : NULL;
        $equivalencia = trim($_POST['equivalencia']) != "" ? trim($_POST['equivalencia']) : NULL;
        $ativ = trim($_POST['ativ']) != "" ? trim($_POST['ativ']) : NULL;

        $cursoAtiv = new CursoAtiv();
        $cursoAtiv->setId($id);
        $cursoAtiv->setCargaHorariaMax($cargaHorariaMax);
        $cursoAtiv->setEquivalencia($equivalencia);
        
        $curso = new Curso();
        $curso->setId($idCurso);

        $tipoAtiv = new TipoAtiv();
        $tipoAtiv->setId($ativ);
        
        $cursoAtiv->setCurso($curso);
        $cursoAtiv->setTipoAtiv($tipoAtiv);

        $this->cursoAtivDao->insert($cursoAtiv);

        header("location: " . BASEURL . "/controller/CursoAtivController.php?action=list&id=".$idCurso);
    }

}


new CursoAtivController();