<?php


include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/CursoAtiv.php");
include_once(__DIR__ . "/../model/TipoAtiv.php");
include_once(__DIR__ . "/../model/Curso.php");

class CursoAtivDAO{

    public function insert(CursoAtiv $cursoAtiv){
        $conn = Connection::getConn();

        $sql = "INSERT INTO CursoAtividade (cargaHorariaMaxima, equivalencia, codigoAtividade, TipoAtividade_id, Curso_id) VALUES (:cargaHorariaMaxima, :equivalencia, :codigoAtividade, :TipoAtividade_id, :Curso_id)";
        $stm = $conn->prepare($sql);
        $stm->bindValue("cargaHorariaMaxima", $cursoAtiv->getCargaHorariaMax());
        $stm->bindValue("equivalencia", $cursoAtiv->getEquivalencia());
        $stm->bindValue("codigoAtividade", $cursoAtiv->getCodigo());
        $stm->bindValue("TipoAtividade_id", $cursoAtiv->getTipoAtiv()->getId());
        $stm->bindValue("Curso_id", $cursoAtiv->getCurso()->getId());
        $stm->execute();
    }

    public function update(CursoAtiv $cursoAtiv){
        $conn = Connection::getConn();

        $sql = "UPDATE CursoAtividade SET cargaHorariaMaxima = :cargaHorariaMaxima, codigoAtividade = :codigoAtividade, equivalencia = :equivalencia,  TipoAtividade_id = :TipoAtividade_id, Curso_id = :Curso_id WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("cargaHorariaMaxima", $cursoAtiv->getCargaHorariaMax());
        $stm->bindValue("codigoAtividade", $cursoAtiv->getCodigo());
        $stm->bindValue("equivalencia", $cursoAtiv->getEquivalencia());
        $stm->bindValue("TipoAtividade_id", $cursoAtiv->getTipoAtiv()->getId());
        $stm->bindValue("Curso_id", $cursoAtiv->getCurso()->getId());
        $stm->bindValue("id", $cursoAtiv->getId());
        $stm->execute();
    }

    public function findById($id) : ?CursoAtiv{
        $conn = Connection::getConn();

        $sql = "SELECT ca.*, ta.nomeAtividade FROM CursoAtividade ca JOIN TipoAtividade ta ON ca.TipoAtividade_id = ta.id WHERE ca.id = ? ORDER BY ca.codigoAtividade";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();
        
        if(empty($result))
            return null;

        $cursos = $this->mapAtivs($result);
        return $cursos[0];
    }

    public function findByCodigo($codigo) : ?CursoAtiv{
        $conn = Connection::getConn();

        $sql = "SELECT * FROM CursoAtividade WHERE codigoAtividade = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$codigo]);
        $result = $stm->fetchAll();
        
        if(empty($result))
            return null;

        $cursos = $this->mapAtivs($result);
        return $cursos[0];
    }

    public function findByIdCurso(int $curso_id){
        $conn = Connection::getConn();
        $sql = "SELECT ca.*, ta.nomeAtividade FROM CursoAtividade ca JOIN TipoAtividade ta ON ca.TipoAtividade_id = ta.id WHERE ca.Curso_id = ? ORDER BY ca.codigoAtividade;
";
        $stm = $conn->prepare($sql);
        $stm->execute([$curso_id]);
        $result = $stm->fetchAll();
        $cursoAtiv = $this->mapAtivs($result);
        return $cursoAtiv;

    }

    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM CursoAtividade WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function deleteByIdCurso(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM CursoAtividade WHERE Curso_id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function listByCurso(int $idCurso){
        $conn = Connection::getConn();
    
        $sql = "SELECT ca.*, ta.nomeAtividade FROM CursoAtividade ca JOIN TipoAtividade ta ON ca.TipoAtividade_id = ta.id WHERE ca.Curso_id = ? ORDER BY ca.codigoAtividade";
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
            $ativ->setCodigo($reg['codigoAtividade']);

            $tipoAtiv = new TipoAtiv();
            $tipoAtiv->setId($reg['TipoAtividade_id']);
            if(isset($reg['nomeAtividade']))
                $tipoAtiv->setNomeAtiv($reg['nomeAtividade']);
            $ativ->setTipoAtiv($tipoAtiv);
            
            $curso = new Curso();
            $curso->setId($reg['Curso_id']);
            $ativ->setCurso($curso);
            array_push($ativs, $ativ);
        }

        return $ativs;
    }
}


?>