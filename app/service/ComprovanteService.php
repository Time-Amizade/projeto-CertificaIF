<?php

require_once(__DIR__.'/../model/Comprovante.php');

class ComprovanteService{
    
    public function validarDados(Comprovante $comprovante){
        $erros = array();

        //Validar campos vazios
        if (! $comprovante->getTitulo())
            array_push($erros, "O campo [Título] é obrigatório.");

        if (! $comprovante->getHoras())
            array_push($erros, "O campo [Horas] é obrigatório.");

        if (! $comprovante->getArquivo())
            array_push($erros, "O campo [Arquivo] é obrigatório.");

        if (! $comprovante->getCursoAtiv())
            array_push($erros, "O campo [Tipo da atividade] é obrigatório.");

        return $erros;
    }
}



?>