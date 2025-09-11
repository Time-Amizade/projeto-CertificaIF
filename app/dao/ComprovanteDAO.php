<?php

include_once(__DIR__. "/../connection/Connection.php");
include_once(__DIR__. "/../model/Comprovante.php");
include_once(__DIR__. '/../model/enum/ComprovanteStatus.php');
include_once(__DIR__. "/../dao/CursoAtivDAO.php");
include_once(__DIR__. "/../dao/UsuarioDAO.php");

class ComprovanteDAO{

    public function listByUserId($id){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Comprovante c WHERE c.Usuario_id = ? ORDER BY c.id ";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();
        
        return $this->mapComp($result);
    }

    public function listByIdFilter($id, $status1, $status2){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Comprovante WHERE Usuario_id = :usuario_id AND status IN (:status1, :status2)";
        $stm = $conn->prepare($sql);
        $stm->bindValue(":usuario_id", $id);
        $stm->bindValue(":status1", $status1);
        $stm->bindValue(":status2", $status2);
        $stm->execute();

        return $this->mapComp($stm->fetchAll());
    }

    public function listByCurso($idCurso){
        $conn = Connection::getConn();

        $sql = "SELECT c.* FROM Comprovante c JOIN CursoAtividade ca ON c.CursoAtividade_id = ca.id WHERE ca.Curso_id = ? AND c.status = ?; ";
        $stm = $conn->prepare($sql);    
        $stm->execute([$idCurso, ComprovanteStatus::PENDENTE]);
        $result = $stm->fetchAll();
        
        return $this->mapComp($result);
    }

    public function findById($id){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Comprovante c WHERE c.id = ? ";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();
        
        $comprovantes = $this->mapComp($result);
        if(count($comprovantes) > 0)
            return $comprovantes[0];
        
        return null;
    }
    
    public function insert(Comprovante $comprovante) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Comprovante (titulo, horas, status, comentario, arquivo, Usuario_id, CursoAtividade_id) VALUES (:titulo, :horas, :status, :comentario, :arquivo, :Usuario_id, :CursoAtividade_id)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("titulo", $comprovante->getTitulo());
        $stm->bindValue("horas", $comprovante->getHoras());
        $stm->bindValue("status", ComprovanteStatus::PENDENTE);
        $stm->bindValue("comentario", null);
        $stm->bindValue("arquivo", $comprovante->getArquivo());
        $stm->bindValue("Usuario_id", $comprovante->getUsuario()->getId());
        $stm->bindValue("CursoAtividade_id", $comprovante->getCursoAtiv()->getId());
        $stm->execute();
    }

    public function cancelById($id){
        $conn = Connection::getConn();

        $sql = "DELETE FROM Comprovante WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function refuseById($id, $comentario = null) {

        if($_GET['comentario']){
            $comentario = $_GET['comentario'];
            if (empty(trim($comentario))) {
                throw new Exception("Comentário obrigatório para recusar o comprovante.");
            }
        }

        $conn = Connection::getConn();
        $sql = "UPDATE Comprovante SET status = ?, comentario = ? WHERE id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([ComprovanteStatus::RECUSADO, $comentario, $id]);
    }

    public function approveById($id){
        $conn = Connection::getConn();

        $sql = "UPDATE Comprovante SET status = ? WHERE id = ?";

        $stm = $conn->prepare($sql);
        $stm->execute(array(ComprovanteStatus::APROVADO, $id));
    }

    public function updateCampo($id, $campo, $valor){
        $conn = Connection::getConn();
        $sql = "UPDATE Comprovante SET $campo = ? WHERE id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$valor, $id]);
    }

    private function mapComp($result) {
        $comprovantes = array();
        foreach ($result as $reg) {
            $comprovante = new Comprovante();
            $comprovante->setId($reg['id']);
            $comprovante->setTitulo($reg['titulo']);
            $comprovante->setHoras($reg['horas']);
            $comprovante->setStatus($reg['status']);
            $comprovante->setComentario($reg['comentario']);
            $comprovante->setArquivo($reg['arquivo']);

            $usuarioDao = new UsuarioDAO();
            $comprovante->setUsuario($usuarioDao->findById($reg['Usuario_id']));

            $cursoAtivDao = new CursoAtivDAO();
            $comprovante->setCursoAtiv($cursoAtivDao->findById($reg['CursoAtividade_id']));
            
            array_push($comprovantes, $comprovante);
        }

        return $comprovantes;
    }
}

?>