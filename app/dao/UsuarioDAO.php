<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

use PSpell\Config;

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../dao/CursoDAO.php");
include_once(__DIR__.'/../model/enum/UsuarioStatus.php');

class UsuarioDAO {

    //Método para listar os usuaários a partir da base de dados
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE u.status = ? ORDER BY u.nomeUsuario";
        $stm = $conn->prepare($sql);    
        $stm->execute([UsuarioStatus::ATIVO]);
        $result = $stm->fetchAll();
        
        return $this->mapUsuarios($result);
    }

    public function listCoord($curso) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE u.Curso_id = ? AND u.funcao = ? AND u.status = ? ORDER BY u.nomeUsuario";  // WHERE vem antes de ORDER BY

        $stm = $conn->prepare($sql);    
        $stm->execute([$curso, UsuarioFuncao::ALUNO, UsuarioStatus::ATIVO]);
        $result = $stm->fetchAll();
        
        return $this->mapUsuarios($result);
    }

    public function listAdm() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE u.funcao = ? AND u.status != ? ORDER BY u.nomeUsuario";  // WHERE vem antes de ORDER BY

        $stm = $conn->prepare($sql);    
        $stm->execute([UsuarioFuncao::COORDENADOR, UsuarioStatus::PENDENTE]);
        $result = $stm->fetchAll();
        
        return $this->mapUsuarios($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE u.id = ? ";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1)
            return $usuarios[0];
        elseif(count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
    }

    public function findByCPF($cpf){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE u.cpf = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$cpf]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1)
            return $usuarios[0];
        elseif(count($usuarios) == 0)
            return null;
    }

    public function findByFilters($status = null, $cursoId = null, $funcao = null){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE ";
        $params = [];

        if (!is_null($status)) {
            $sql .= " u.status = ?";
            $params[] = $status;
        }

        if (!is_null($funcao)) {
            $sql .= " AND u.funcao = ?";
            $params[] = $funcao;
        }

        if (!is_null($cursoId)) {
            $sql .= " AND u.Curso_id = ?";
            $params[] = $cursoId;
        }

        $stm = $conn->prepare($sql);    
        $stm->execute($params);
        $result = $stm->fetchAll();
            
        $usuarios = $this->mapUsuarios($result);
        
        return $usuarios;
    }

    //Método para buscar um usuário por seu email e senha
    public function findByEmailSenha(string $email, string $senha) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Usuario u WHERE BINARY u.email = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$email]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1) {
            //Tratamento para senha criptografada
            if(password_verify($senha, $usuarios[0]->getSenha()))
            {
                if($usuarios[0]->getStatus() === UsuarioStatus::PENDENTE){
                    return UsuarioStatus::PENDENTE;
                }
                else if($usuarios[0]->getStatus() === UsuarioStatus::INATIVO){
                    return UsuarioStatus::INATIVO;
                }
                return $usuarios[0];
            }
            else
                return null;

        } elseif(count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByEmailSenha() - Erro: mais de um usuário encontrado.");
    }

    //Método para inserir um Usuario
    public function insert(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO Usuario (nomeUsuario, dataNascimento, email, senha, cpf, Curso_id, funcao, codigoMatricula, status, fotoPerfil) VALUES (:nome, :dataNascimento, :email, :senha, :cpf, :Curso_id, :funcao, :codigoMatricula, :statusUsuario, :fotoPerfil)";
        
        $senhaCripto = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("dataNascimento", $usuario->getDataNascimento());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", $senhaCripto);
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("Curso_id", $usuario->getCursoid()->getId());
        $stm->bindValue("funcao", $usuario->getFuncao());
        $stm->bindValue("codigoMatricula", $usuario->getCodigoMatricula());
        $stm->bindValue("statusUsuario", UsuarioStatus::PENDENTE);   
        $stm->bindValue("fotoPerfil", 'padrao.png');
        $stm->execute();
    }

    public function confirmSignUp($id){
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET status = :status WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->bindValue("status", UsuarioStatus::ATIVO);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    //Método para atualizar um Usuario
    public function update(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET nomeUsuario = :nome, email = :email, senha = :senha, funcao = :funcao WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("funcao", $usuario->getFuncao());
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    //Método para excluir um Usuario pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM Usuario WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function deactivateById(int $id) {
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET status = :status WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("status", UsuarioStatus::INATIVO);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function deactivateByCurso(int $idCurso){
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET status = :status  WHERE funcao = :funcao AND Curso_id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("status", UsuarioStatus::INATIVO);
        $stm->bindValue("funcao", UsuarioFuncao::COORDENADOR);
        $stm->bindValue("id", $idCurso);
        $stm->execute();
    }

    public function activateById(int $id) {
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET status = :status WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("status", UsuarioStatus::ATIVO);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

     //Método para alterar a foto de perfil de um usuário
    public function updateFotoPerfil(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET fotoPerfil = ? WHERE id = ?";

        $stm = $conn->prepare($sql);
        $stm->execute(array($usuario->getFotoPerfil(), $usuario->getId()));
    }

    public function changePassword($cpf, $senha){
        $conn = Connection::getConn();

        $sql = "UPDATE Usuario SET senha = :senha WHERE cpf = :cpf";

        $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

        $stm = $conn->prepare($sql);
        $stm->bindValue("senha", $senhaCripto);    
        $stm->bindValue("cpf", $cpf);
        $stm->execute();
    }

    public function addHours($id){
        // Obtém a conexão
        $conn = Connection::getConn();

        // Seleciona as horas e o ID do usuário
        $sql = "SELECT horas, Usuario_id FROM Comprovante WHERE id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        
        // Verifica se o resultado foi encontrado
        $result = $stm->fetchObject();
        
        if ($result) {
            // Atualiza a quantidade de horas validadas para o usuário
            $sql = "UPDATE Usuario SET horasValidadas = horasValidadas + ? WHERE id = ?";
            $stm = $conn->prepare($sql);
            $stm->execute([$result->horas, $result->Usuario_id]);
            
        } else {
            echo "Comprovante não encontrado!";
        }
    }

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapUsuarios($result) {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['id']);
            $usuario->setNome($reg['nomeUsuario']);
            $usuario->setDataNascimento($reg['dataNascimento']);
            $usuario->setCpf($reg['cpf']);
            $usuario->setSenha($reg['senha']);
            $usuario->setEmail($reg['email']);
            $usuario->setTelefone($reg['telefone']);
            $usuario->setEndereco($reg['endereco']);
            $usuario->setCodigoMatricula($reg['codigoMatricula']);
            $usuario->setFuncao($reg['funcao']);
            $usuario->setHorasValidadas($reg['horasValidadas']);
            $usuario->setStatus($reg['status']);
            $usuario->setFotoPerfil($reg['fotoPerfil']);
            $cursoDao = new CursoDAO();
            $usuario->setCursoid($cursoDao->findById($reg['Curso_id']));
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

public function updatePerfil(Usuario $usuario) {
    $conn = Connection::getConn();

    // SQL base cpf = :cpf, 
    $sql = "UPDATE Usuario SET 
                nomeUsuario = :nome, 
                email = :email, 
                dataNascimento = :dataNascimento, 
                telefone = :telefone, 
                endereco = :endereco";

    // Se o objeto tiver senha, adiciona no SQL
    // if ($usuario->getSenha()) {
    //     $sql .= ", senha = :senha";
    // }

    $sql .= " WHERE id = :id";

    $stm = $conn->prepare($sql);

    // Bind comum
    $stm->bindValue("nome", $usuario->getNome());
    $stm->bindValue("email", $usuario->getEmail());
    $stm->bindValue("dataNascimento", $usuario->getDataNascimento());
    // $stm->bindValue("cpf", $usuario->getCpf());
    $stm->bindValue("telefone", $usuario->getTelefone());
    $stm->bindValue("endereco", $usuario->getEndereco());
    $stm->bindValue("id", $usuario->getId());

    // Só faz o bind da senha se ela existir
    // if ($usuario->getSenha()) {
    //     $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
    // }

    $stm->execute();
}

}
