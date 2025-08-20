<?php

require_once(__DIR__.'/Controller.php');
require_once(__DIR__.'/../dao/ComprovanteDAO.php');
require_once(__DIR__.'/../dao/CursoAtivDAO.php');
require_once(__DIR__.'/../service/ComprovanteService.php');
require_once(__DIR__.'/../model/Comprovante.php');


class ComprovanteController extends Controller{
    private ComprovanteDAO $compDao;
    private CursoAtivDAO $cursoAtivDao;
    private ComprovanteService $compService;

    public function __construct(){
        if(!$this->usuarioEstaLogado())
            return;
        
        $this->cursoAtivDao = new CursoAtivDAO();
        $this->compDao = new ComprovanteDAO();
        $this->compService = new ComprovanteService();

        $this->handleAction();
    }

    protected function create(){
        $dados['idComp'] = 0;
        $dados['cursoAtivs'] = $this->cursoAtivDao->listByCurso($_SESSION[SESSAO_USUARIO_CURSO]);
        $this->loadView("comprovante/form.php", $dados);
    }

}

new ComprovanteController();
?>