<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../service/CursoService.php");
require_once(__DIR__ . "/CursoAtivController.php");
require_once(__DIR__ . "/../model/Curso.php");

class CursoController extends Controller{
    
    private CursoDAO $cursoDao;
    private CursoService $cursoService;

    public function __construct() {
        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoAdmin()) {
            echo "Acesso negado!";
            exit;
        }
        
        $this->cursoDao = new CursoDAO();
        $this->cursoService = new CursoService();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = ""){
        $dados["lista"] = $this->cursoDao->list();
        
        $this->loadView("curso/list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function create() {
        $dados['id'] = 0;
        
        $this->loadView("curso/form.php", $dados);
    }

    protected function save(){

        $id = $_POST['id'];
        $nome = trim($_POST['nomeCurso']) != "" ? trim($_POST['nomeCurso']) : NULL;
        $cargaHoraria = trim($_POST['cargaHoraria']) != "" ? trim($_POST['cargaHoraria']) : NULL;
        $tipo = trim($_POST['tipo']) != "" ? trim($_POST['tipo']) : NULL;
        $cargaHorariaAtiv = trim($_POST['cargaHorariaAtiv']) != "" ? trim($_POST['cargaHorariaAtiv']) : NULL;
        $equivalencia = trim($_POST['equivalencia']) != "" ? trim($_POST['equivalencia']) : NULL;

        $curso = new Curso();
        $curso->setId($id);
        $curso->setNomeCurso($nome);
        $curso->setCargaHorariaAtivComplement($cargaHoraria);

        $erros = $this->cursoService->validarDados($curso);
        $cursoId = $curso->getId();

        try{
            if($cursoId == 0){
                $cursoId = $this->cursoDao->insert($curso);
            }
        }catch(PDOException $e){
            array_push($erros, "Erro ao gravar no banco de dados!");
        }
        
        //$cursoAtivCont = new CursoAtivController();
        //$cursoAtivCont->save($cursoId, $tipo, $cargaHorariaAtiv, $equivalencia);
        
        header("location: " . HOME_PAGE);
    }
}


new CursoController();
?>