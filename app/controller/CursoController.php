<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../dao/CursoAtivDAO.php");
require_once(__DIR__ . "/../service/CursoService.php");
require_once(__DIR__ . "/../model/Curso.php");

class CursoController extends Controller{
    
    private CursoDAO $cursoDao;
    private CursoService $cursoService;
    private CursoAtivDAO $cursoAtivDao;

    public function __construct() {
        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoAdmin()) {
            echo "Acesso negado!";
            exit;
        }
        
        $this->cursoDao = new CursoDAO();
        $this->cursoAtivDao = new CursoAtivDAO();
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

    protected function edit(){
        $dados['curso'] = $this->cursoDao->findById($_GET['id']);
        $dados['id'] = $_GET['id'];

        $this->loadView("curso/form.php", $dados);
    }

    protected function delete(){
        $id = $_GET['id'];
        $this->cursoAtivDao->deleteByIdCurso($id);
        $this->cursoDao->deleteById($id);
        header("location: " . BASEURL . "/controller/CursoController.php?action=list");
    }

    protected function save(){
        $id = $_POST['id'];
        $nome = trim($_POST['nomeCurso']) != "" ? trim($_POST['nomeCurso']) : NULL;
        $cargaHoraria = trim($_POST['cargaHoraria']) != "" ? trim($_POST['cargaHoraria']) : NULL;
        $curso = new Curso();
        $curso->setId($id);
        $curso->setNomeCurso($nome);
        $curso->setCargaHorariaAtivComplement($cargaHoraria);

        $erros = $this->cursoService->validarDados($curso);

        if(!$erros){
            try{
                if($id == 0){
                    $this->cursoDao->insert($curso);
                }else{
                    $this->cursoDao->update($curso);
                }
            }catch(PDOException $e){
                array_push($erros, "Erro ao gravar no banco de dados!");
            }
            header('Location: '. CURSO_PAGE);
        }
        $dados['id'] = $id;
        $dados['curso'] = $curso;
        $msgErro = implode("<br>", $erros);

        $this->loadView("curso/form.php", $dados, $msgErro);
    }
}


new CursoController();
?>