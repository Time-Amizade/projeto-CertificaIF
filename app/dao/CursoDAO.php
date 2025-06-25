<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Curso.php");

class CursoDAO{
    public function insert(Curso $curso) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Curso (nomeCurso, cargaHorariaAtivComplement) VALUES (:nomeCurso, :cargaHorariaAtivComplement)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nomeCurso", $curso->getNomeCurso());
        $stm->bindValue("cargaHorariaAtivComplement", $curso->getCargaHorariaAtivComplement());
        $stm->execute();

        return $conn->lastInsertId();
    }
}

?> 