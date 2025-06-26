<?php 

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/CursoAtiv.php");
include_once(__DIR__ . "/../model/TipoAtiv.php");
include_once(__DIR__ . "/../model/Curso.php");

class CursoAtivDAO{

    public function insert(CursoAtiv $cursoAtiv){
        $conn = Connection::getConn();

        $sql = "INSERT INTO CursoAtividade (cargaHorariaMaxima, equivalencia, TipoAtividade_id, Curso_id) VALUES (:cargaHorariaMaxima, :equivalencia, :TipoAtividade_id, :Curso_id)";
        $stm = $conn->prepare($sql);
        $stm->bindValue("cargaHorariaMaxima", $cursoAtiv->getCargaHorariaMax());
        $stm->bindValue("equivalencia", $cursoAtiv->getEquivalencia());
        $stm->bindValue("TipoAtividade_id", $cursoAtiv->getTipoAtiv()->getId());
        $stm->bindValue("Curso_id", $cursoAtiv->getCurso()->getId());
        $stm->execute();
    }

    public function listByCurso(int $idCurso){
        $conn = Connection::getConn();
    
        $sql = "SELECT * FROM CursoAtividade ca WHERE ca.Curso_id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$idCurso]);
        $result = $stm->fetchAll();
            
        return $this->mapAtivs($result);
    }

    private function mapAtivs($result) {
        $ativs = array();
        foreach ($result as $reg) {
            $ativ = new CursoAtiv();
            $ativ->setId($reg['id']);
            $ativ->setCargaHorariaMax($reg['cargaHorariaMaxima']);
            $ativ->setEquivalencia($reg['equivalencia']);

            $tipoAtiv = new TipoAtiv();
            $tipoAtiv->setId($reg['TipoAtividade_id']);
            $ativ->setTipoAtiv($tipoAtiv);
            
            $ativ->setCurso($reg['Curso_id']);
            array_push($ativs, $ativ);
        }

        return $ativs;
    }
}


?>