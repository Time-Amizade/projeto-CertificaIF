<?php
#Nome do arquivo: ComprovanteStatus.php
#Objetivo: classe Enum para os status do model de Comprovante

class ComprovanteStatus {

    public static string $SEPARADOR = "|";

    const APROVADO = "APROVADO";
    const RECUSADO = "RECUSADO";
    const PENDENTE = "PENDENTE";

    public static function getAllAsArray() {
        return [ComprovanteStatus::APROVADO, ComprovanteStatus::RECUSADO, ComprovanteStatus::PENDENTE];
    }

}