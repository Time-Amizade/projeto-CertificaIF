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

    public function list(){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Curso c ORDER BY c.id";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapCursos($result);
    }

    public function findById($id) : ?Curso{
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Curso c WHERE c.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();
        
        if(empty($result))
            return null;

        $cursos = $this->mapCursos($result);
        return $cursos[0];
    }

    private function mapCursos($result) {
        $cursos = array();
        foreach ($result as $reg) {
            $curso = new Curso();
            $curso->setId($reg['id']);
            $curso->setNomeCurso($reg['nomeCurso']);
            $curso->setCargaHorariaAtivComplement($reg['cargaHorariaAtivComplement']);
            array_push($cursos, $curso);
        }

        return $cursos;
    }
}

?> 