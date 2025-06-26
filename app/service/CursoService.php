<?php 

require_once(__DIR__ . "/../model/Curso.php");

class CursoService{

    public function validarDados(Curso $curso){
        $erros = array();

        if(! $curso->getNomeCurso())
            array_push($erros, "O campo [Nome do curso] é obrigatório.");

        if(! $curso->getCargaHorariaAtivComplement())
            array_push($erros, "O campo [Carga horária do curso] é obrigatório.");
        return $erros;
    }
}

?>