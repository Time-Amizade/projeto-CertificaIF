<?php
    
require_once(__DIR__ . "/../model/Usuario.php");

class UsuarioService {

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Usuario $usuario, ?string $confSenha) {
        $erros = array();

        //Validar campos vazios
        if (! $usuario->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");

        if (! $usuario->getDataNascimento())
            array_push($erros, "O campo [Data de Nascimento] é obrigatório.");

        if (! $usuario->getEmail())
            array_push($erros, "O campo [Email] é obrigatório.");

        if (! $usuario->getSenha())
            array_push($erros, "O campo [Senha] é obrigatório.");

        if (! $confSenha)
            array_push($erros, "O campo [Confirmação da Senha] é obrigatório.");

        if (! $usuario->getCpf())
            array_push($erros, "O campo [Cpf] é obrigatório.");

        if (! $usuario->getCursoid())
            array_push($erros, "O campo [Curso] é obrigatório.");

        if (! $usuario->getFuncao()) 
            array_push($erros, "O campo [Função] é obrigatório.");

        if($usuario->getFuncao() == 'ALUNO' && !$usuario->getCodigoMatricula())
            array_push($erros, "O campo [Código de matrícula] é obrigatório para alunos.");

        //Validar se a senha é igual a contra senha
        if($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            array_push($erros, "O campo [Senha] deve ser igual ao [Confirmação da senha].");

        return $erros;
    }

    /* Método para validar se o usuário selecionou uma foto de perfil */
    public function validarFotoPerfil(array $foto) {
        $erros = array();
        
        if($foto['size'] <= 0)
            array_push($erros, "Informe a foto para o perfil!");

        return $erros;
    }

}
