<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Curso.php");

class CursoDAO{
    public function insert(Curso $curso) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO curso (nomeCurso, cargaHorariaAtivComplement) VALUES (:nome, :cargaHorariaAtivComplement)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $curso->getNomeCurso());
        $stm->bindValue("cargaHorariaAtivComplement", $curso->getcargaHorariaAtivComplement());
        $stm->execute();
    }
}

?>