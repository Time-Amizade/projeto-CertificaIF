<?php

require_once(__DIR__.'/enum/ComprovanteStatus.php');
require_once(__DIR__.'/Usuario.php');
require_once(__DIR__.'/CursoAtiv.php');

class Comprovante implements JsonSerializable{
    private ?int $id;
    private ?string $titulo;
    private ?int $horas;
    private ?string $status;
    private ?string $comentario;
    private ?string $arquivo = '';
    private ?Usuario $usuario;
    private ?CursoAtiv $cursoAtiv;

    public function jsonSerialize(): array
    {
        return array(
            "id" => $this->id,
            "titulo" => $this->titulo,
            "horas" => $this->horas,
            "status" => $this->status,
            "comentario" => $this->comentario,
            "arquivo" => $this->arquivo,
            "usuario" =>  $this->usuario?->jsonSerialize(),
            "cursoAtiv" =>  $this->cursoAtiv?->jsonSerialize(),
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
     * Get the value of titulo
     */
    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo(?string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of horas
     */
    public function getHoras(): ?int
    {
        return $this->horas;
    }

    /**
     * Set the value of horas
     */
    public function setHoras(?int $horas): self
    {
        $this->horas = $horas;

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
     * Get the value of comentario
     */
    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    /**
     * Set the value of comentario
     */
    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get the value of arquivo
     */
    public function getArquivo(): ?string
    {
        return $this->arquivo;
    }

    /**
     * Set the value of arquivo
     */
    public function setArquivo(?string $arquivo): self
    {
        $this->arquivo = $arquivo;

        return $this;
    }

    /**
     * Get the value of usuario
     */
    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of cursoAtiv
     */
    public function getCursoAtiv(): ?CursoAtiv
    {
        return $this->cursoAtiv;
    }

    /**
     * Set the value of cursoAtiv
     */
    public function setCursoAtiv(?CursoAtiv $cursoAtiv): self
    {
        $this->cursoAtiv = $cursoAtiv;

        return $this;
    }
}


?>