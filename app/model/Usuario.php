<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioFuncao.php");

class Usuario implements JsonSerializable {

    private ?int $id;
    private ?string $nome;
    private ?string $dataNascimento;
    private ?string $cpf;
    private ?string $senha;
    private ?string $email;
    private ?string $telefone;
    private ?string $endereco;
    private ?string $codigoMatricula;
    private ?string $funcao;
    private ?string $horasValidadas;
    private ?string $status;
    private ?string $Cursoid;
    private ?string $fotoPerfil;

    public function jsonSerialize(): array
    {
        return array(
            "id" => $this->id,
            "nome" => $this->nome,
            "email" => $this->email,
            "dataNascimento" => $this->dataNascimento,
            "cpf" => $this->cpf,
            'senha' => $this->senha,
            "telefone" => $this->telefone,
            "endereco" => $this->endereco,
            "codigoMatricula" => $this->codigoMatricula,
            "funcao" => $this->funcao,
            "horasValidadas" => $this->horasValidadas,
            "status" => $this->status,
            "Cursoid" => $this->Cursoid,
            "fotoPerfil" => $this->fotoPerfil
        );
    }
    
    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of dataNascimento
     */
    public function getDataNascimento(): ?string
    {
        return $this->dataNascimento;
    }

    /**
     * Set the value of dataNascimento
     */
    public function setDataNascimento(?string $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha(): ?string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */
    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telefone
     */
    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     */
    public function setTelefone(?string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get the value of endereco
     */
    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     */
    public function setEndereco(?string $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get the value of codigoMatricula
     */
    public function getCodigoMatricula(): ?string
    {
        return $this->codigoMatricula;
    }

    /**
     * Set the value of codigoMatricula
     */
    public function setCodigoMatricula(?string $codigoMatricula): self
    {
        $this->codigoMatricula = $codigoMatricula;

        return $this;
    }

    /**
     * Get the value of funcao
     */
    public function getFuncao(): ?string
    {
        return $this->funcao;
    }

    /**
     * Set the value of funcao
     */
    public function setFuncao(?string $funcao): self
    {
        $this->funcao = $funcao;

        return $this;
    }

    /**
     * Get the value of horasValidadas
     */
    public function getHorasValidadas(): ?string
    {
        return $this->horasValidadas;
    }

    /**
     * Set the value of horasValidadas
     */
    public function setHorasValidadas(?string $horasValidadas): self
    {
        $this->horasValidadas = $horasValidadas;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of Cursoid
     */
    public function getCursoid(): ?string
    {
        return $this->Cursoid;
    }

    /**
     * Set the value of Cursoid
     */
    public function setCursoid(?string $Cursoid): self
    {
        $this->Cursoid = $Cursoid;

        return $this;
    }

    /**
     * Get the value of fotoPerfil
     */
    public function getFotoPerfil(): ?string
    {
        return $this->fotoPerfil;
    }

    /**
     * Set the value of fotoPerfil
     */
    public function setFotoPerfil(?string $fotoPerfil): self
    {
        $this->fotoPerfil = $fotoPerfil;

        return $this;
    }
    
}