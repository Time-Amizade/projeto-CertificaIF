<?php 

require_once(__DIR__ . "/../model/CursoAtiv.php");
require_once(__DIR__. "/../dao/CursoAtivDAO.php");

class CursoAtivService{

    public function validarDados(CursoAtiv $cursoAtiv){
        $erros = array();

        if(!$cursoAtiv->getCodigo())
            array_push($erros, "O campo [Código da atividade] é obrigatório.");
        
        $cursoAtivDao = new CursoAtivDAO();

        if($cursoAtivDao->findByCodigo($cursoAtiv->getCodigo())){
            array_push($erros, "O código informado já existe em outra atividade.");
        }

        
        if(!$cursoAtiv->getTipoAtiv()->getId())
            array_push($erros, "O campo [Tipo da atividade] é obrigatório.");

        if(!$cursoAtiv->getCargaHorariaMax())
            array_push($erros, "O campo [Carga horária da atividade] é obrigatório.");

        if(!$cursoAtiv->getEquivalencia())
            array_push($erros, "O campo [Equivalência] é obrigatório.");

        return $erros;
    }
}

?>