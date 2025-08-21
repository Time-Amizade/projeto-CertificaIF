<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Comprovante.php");
include_once(__DIR__.'/../model/CursoAtiv.php');
include_once(__DIR__.'/../model/enum/ComprovanteStatus.php');
include_once(__DIR__ . "/../dao/ComprovanteDAO.php");

class ComprovanteDAO{
    
    //Método para inserir um comprovante
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

    public function update(Comprovante $comprovante){
        exit;
    }
}

?>