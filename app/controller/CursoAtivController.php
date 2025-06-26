<?php 

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoAtivDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../model/CursoAtiv.php");

class CursoAtivController extends Controller{

    private CursoAtivDAO $cursoAtivDao;
    private CursoDAO $cursoDao;
    //private CursoService $cursoService;

    public function __construct() {
        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoAdmin()) {
            echo "Acesso negado!";
            exit;
        }
        
        $this->cursoAtivDao = new CursoAtivDAO();
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

        //$this->loadView("atividade/list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function findCursoById() : ?Curso{
        $id = 0;
        if(isset($_GET["id"]))
            $id = $_GET["id"];

        //Busca os cursos na base pelo ID    
        return $this->cursoDao->findById($id);
    }

    protected function save($cursoId, $tipoAtivId, $cargaHorariaAtiv, $equivalencia){

        /*
        $cursoAtiv = new CursoAtiv();
        $cursoAtiv->setTipoAtivId($tipoAtivId);
        $cursoAtiv->setCargaHorariaMax($cargaHorariaAtiv);
        $cursoAtiv->setEquivalencia($equivalencia);
        $cursoAtiv->setCursoId($cursoId);

        
        $this->cursoAtivDao->insert($cursoAtiv);
        */
    }

}


new CursoAtivController();