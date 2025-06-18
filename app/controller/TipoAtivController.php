<?php  

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/TipoAtivDAO.php");
require_once(__DIR__ . "/../model/TipoAtiv.php");

class TipoAtivController extends Controller{

    private TipoAtivDAO $tipoAtivDao;


    public function __construct() {
        if(!$this->usuarioEstaLogado())
            return;

        //Restringir o acesso apenas para administradores
        if(!$this->usuarioLogadoFuncaoAdmin()) {
            echo "Acesso negado!";
            exit;
        }

        $this->tipoAtivDao = new TipoAtivDAO();

        //$this->handleAction();
    }

    public function list(){
        return $dados['listaTipo'] = $this->tipoAtivDao->list();
    }
}
new TipoAtivController();

?>