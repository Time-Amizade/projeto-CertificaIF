<?php 

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/TipoAtiv.php");

class TipoAtivDAO{


    public function list(){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM TipoAtividade t ORDER BY t.id";
        $stm = $conn->prepare(query: $sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapTipos($result);
    }

    public function mapTipos($result){
        $tipos = array();
        foreach ($result as $reg) {
            $tipoAtiv = new TipoAtiv();
            $tipoAtiv->setId($reg['id']);
            $tipoAtiv->setNomeAtiv($reg['nomeAtividade']);
            $tipoAtiv->setDescAtiv($reg['descricao']);
            array_push($tipos, $tipoAtiv);
        }

        return $tipos;
    }
}

?>