<?php 

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoAtivDAO.php");
require_once(__DIR__ . "/../model/CursoAtiv.php");

class CursoAtivController extends Controller{

    private CursoAtivDAO $cursoAtivDao;
    private CursoService $cursoService;

    public function __construct() {
        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoAdmin()) {
            echo "Acesso negado!";
            exit;
        }
        
        $this->cursoAtivDao = new CursoAtivDAO();
        $this->cursoService = new CursoService();

        //$this->handleAction();
    } 

    public function save($cursoId, $tipoAtivId, $cargaHorariaAtiv, $equivalencia){
        $cursoAtiv = new CursoAtiv();
        $cursoAtiv->setTipoAtivId($tipoAtivId);
        $cursoAtiv->setCargaHorariaMax($cargaHorariaAtiv);
        $cursoAtiv->setEquivalencia($equivalencia);
        $cursoAtiv->setCursoId($cursoId);

        $this->cursoAtivDao->insert($cursoAtiv);
    }
}

?>