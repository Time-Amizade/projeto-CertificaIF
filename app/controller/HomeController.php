<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__. "/../dao/ComprovanteDAO.php");

class HomeController extends Controller {

    private UsuarioDAO $usuarioDao;
    private ComprovanteDAO $comprovanteDao;

    public function __construct() {
        //Verificar se o usuário está logado
        if(! $this->usuarioEstaLogado())
            return;

        $this->usuarioDao = new UsuarioDAO();
        $this->comprovanteDao = new ComprovanteDAO();

        //Tratar a ação solicitada no parâmetro "action"
        $this->handleAction();
    }

    protected function home() {
        $dados = array();

        /*
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL])) {
            if ($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::ADMINISTRADOR) {
                $dados['usuarios'] = $this->usuarioDao->findByFilters('PENDENTE', null, 'COORDENADOR');
            } else if ($_SESSION[SESSAO_USUARIO_PAPEL] == UsuarioFuncao::COORDENADOR) {
                $dados['usuarios'] = $this->usuarioDao->findByFilters('PENDENTE', $_SESSION[SESSAO_USUARIO_CURSO], 'ALUNO');
            }else{
                $dados['comps'] = $this->comprovanteDao->list($_SESSION[SESSAO_USUARIO_ID]);
            }
        }
    */
        $this->loadView("home/home.php", $dados);
    }

    protected function listJson() {
        $dados = [];
        $comprovantes = [];
        $usuarioFunc = null;
        
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL])) {
            $usuarioFunc = $_SESSION[SESSAO_USUARIO_PAPEL];
            
            if ($usuarioFunc == UsuarioFuncao::ADMINISTRADOR) {
                $dados = $this->usuarioDao->findByFilters(UsuarioStatus::PENDENTE, null, UsuarioFuncao::COORDENADOR);
            } else if ($usuarioFunc == UsuarioFuncao::COORDENADOR) {
                $dados = $this->usuarioDao->findByFilters(UsuarioStatus::PENDENTE, $_SESSION[SESSAO_USUARIO_CURSO], UsuarioFuncao::ALUNO);
                $comprovantes = $this->comprovanteDao->listByCurso($_SESSION[SESSAO_USUARIO_CURSO]);
            }else{
                $comprovantes = $this->comprovanteDao->listByUserId($_SESSION[SESSAO_USUARIO_ID]);
            }
        }

        $json = json_encode([
            'tipo' => $usuarioFunc,
            'dados' => array_map(fn($usuario) => $usuario->jsonSerialize(), $dados),
            'comprovantes' => array_map(function($comprovante) {
                return [
                    'comprovante' => $comprovante->jsonSerialize(),
                    'cursoAtiv' => $comprovante->getCursoAtiv()->jsonSerialize(),
                    'aluno' => $comprovante->getUsuario()->jsonSerialize()
                ];
            }, $comprovantes)
        ], JSON_PRETTY_PRINT);

        if ($json === false) {
            echo "Erro ao gerar JSON: " . json_last_error_msg();
            return;
        }
        
        echo $json;    
    }
    
}

//Criar o objeto do controller
new HomeController();