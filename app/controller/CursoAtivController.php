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

    protected function findById() : ?CursoAtiv{
        $id = 0;
        if(isset($_GET["id"]))
            $id = $_GET["id"];

        //Busca os cursos na base pelo ID    
        return $this->cursoAtivDao->findById($id);
    }

    protected function create(){
        $dados['id'] = 0; 
        $dados['idCurso'] = $_GET['id'];
        $dados['listaTipo'] = $this->tipoAtivDao->list();
        
        $this->loadView("atividade/form.php", $dados);
    }

    protected function edit(){
        $dados['id'] = $_GET['id']; 
        $dados['ativ'] = $this->findById();
        $dados['idCurso'] = $dados['ativ']->getCurso()->getId();
        $dados['listaTipo'] = $this->tipoAtivDao->list();
        
        $this->loadView("atividade/form.php", $dados);
    }

    protected function delete(){
        $ativ = $this->findById();
        $this->cursoAtivDao->deleteById($ativ->getId());
        header("location: " . BASEURL . "/controller/CursoAtivController.php?action=list&id=".$ativ->getCurso()->getId());
    }

    protected function save(){
        
        $id = $_POST['id'];
        $idCurso = $_POST['idCurso'];
        $codigo = trim($_POST['codigo']) != "" ? trim($_POST['codigo']) : NULL; 
        $cargaHorariaMax = trim($_POST['cargaHorariaMax']) != "" ? trim($_POST['cargaHorariaMax']) : NULL;
        $equivalencia = trim($_POST['equivalencia']) != "" ? trim($_POST['equivalencia']) : NULL;
        $ativ = trim($_POST['ativ']) != "" ? trim($_POST['ativ']) : NULL;

        $cursoAtiv = new CursoAtiv();
        $cursoAtiv->setId($id);
        $cursoAtiv->setCodigo($codigo);
        $cursoAtiv->setCargaHorariaMax($cargaHorariaMax);
        $cursoAtiv->setEquivalencia($equivalencia);
        
        $curso = new Curso();
        $curso->setId($idCurso);

        $tipoAtiv = new TipoAtiv();
        $tipoAtiv->setId($ativ);
        
        $cursoAtiv->setCurso($curso);
        $cursoAtiv->setTipoAtiv($tipoAtiv);

        $erros = array();
        try{
            if($id == 0){
                $this->cursoAtivDao->insert($cursoAtiv);
            }else{
                $this->cursoAtivDao->update($cursoAtiv);
            }
        }catch(PDOException $e){
            array_push($erros, "Erro ao gravar no banco de dados!");
        }

        header("location: " . BASEURL . "/controller/CursoAtivController.php?action=list&id=".$idCurso);
    }

}


new CursoAtivController();