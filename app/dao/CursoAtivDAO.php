<?php 

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/CursoAtiv.php");

class CursoAtivDAO{

    public function insert(CursoAtiv $cursoAtiv){
        $conn = Connection::getConn();

        $sql = "INSERT INTO CursoAtividade (cargaHorariaMaxima, equivalencia, TipoAtividade_id, Curso_id) VALUES (:cargaHorariaMaxima, :equivalencia, :TipoAtividade_id, :Curso_id)";
        $stm = $conn->prepare($sql);
        $stm->bindValue("cargaHorariaMaxima", $cursoAtiv->getCargaHorariaMax());
        $stm->bindValue("equivalencia", $cursoAtiv->getEquivalencia());
        $stm->bindValue("TipoAtividade_id", $cursoAtiv->getTipoAtivId());
        $stm->bindValue("Curso_id", $cursoAtiv->getCursoId());
        $stm->execute();
    }
}

?>