<?php
#Nome do arquivo: UsuarioFuncao.php
#Objetivo: classe Enum para os papeis de permissões do model de Usuario

class UsuarioStatus {

    public static string $SEPARADOR = "|";

    const ATIVO = "ATIVO";
    const INATIVO = "INATIVO";
    const PENDENTE = "PENDENTE";

    public static function getAllAsArray() {
        return [UsuarioStatus::ATIVO, UsuarioStatus::INATIVO, UsuarioStatus::PENDENTE];
    }

}
