<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../service/CursoService.php");
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

    protected function create() {
        $dados['id'] = 0;

        $this->loadView("curso/form.php", $dados);
    }
}


new CursoController();
?>