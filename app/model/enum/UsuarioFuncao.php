<?php
#Nome do arquivo: UsuarioFuncao.php
#Objetivo: classe Enum para os papeis de permissões do model de Usuario

class UsuarioFuncao {

    public static string $SEPARADOR = "|";

    const ALUNO = "ALUNO";
    const COORDENADOR = "COORDENADOR";
    const ADMINISTRADOR = "ADMINISTRADOR";

    public static function getAllAsArray() {
        return [UsuarioFuncao::ALUNO, UsuarioFuncao::COORDENADOR, UsuarioFuncao::ADMINISTRADOR];
    }

}

