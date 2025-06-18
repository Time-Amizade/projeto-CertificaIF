<?php 

require_once(__DIR__.'/Curso.php');
require_once(__DIR__.'/TipoAtiv.php');

class CursoAtiv{
    
    private ?int $id;
    private ?int $cargaHorariaMax;
    private ?string $equivalencia;
    private ?int $cursoId;
    private ?int $tipoAtivId;
    

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
     * Get the value of cargaHorariaMax
     */
    public function getCargaHorariaMax(): ?int
    {
        return $this->cargaHorariaMax;
    }

    /**
     * Set the value of cargaHorariaMax
     */
    public function setCargaHorariaMax(?int $cargaHorariaMax): self
    {
        $this->cargaHorariaMax = $cargaHorariaMax;

        return $this;
    }

    /**
     * Get the value of equivalencia
     */
    public function getEquivalencia(): ?string
    {
        return $this->equivalencia;
    }

    /**
     * Set the value of equivalencia
     */
    public function setEquivalencia(?string $equivalencia): self
    {
        $this->equivalencia = $equivalencia;

        return $this;
    }

    /**
     * Get the value of cursoId
     */
    public function getCursoId(): ?int
    {
        return $this->cursoId;
    }

    /**
     * Set the value of cursoId
     */
    public function setCursoId(?int $cursoId): self
    {
        $this->cursoId = $cursoId;

        return $this;
    }

    /**
     * Get the value of tipoAtivId
     */
    public function getTipoAtivId(): ?int
    {
        return $this->tipoAtivId;
    }

    /**
     * Set the value of tipoAtivId
     */
    public function setTipoAtivId(?int $tipoAtivId): self
    {
        $this->tipoAtivId = $tipoAtivId;

        return $this;
    }
}

?>