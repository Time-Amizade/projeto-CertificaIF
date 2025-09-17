<?php 

require_once(__DIR__.'/Curso.php');
require_once(__DIR__.'/TipoAtiv.php');

class CursoAtiv implements JsonSerializable {
    
    private ?int $id;
    private ?int $cargaHorariaMax;
    private ?string $equivalencia;
    private ?int $codigo;
    private ?Curso $curso;
    private ?TipoAtiv $tipoAtiv;
    
    
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'cargaHorariaMax' => $this->cargaHorariaMax,
            'equivalencia' => $this->equivalencia,
            'codigo' => $this->codigo,
            'curso' => $this->curso,
            'tipoAtiv' => $this->tipoAtiv?->jsonSerialize(),
        ];
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
     * Get the value of curso
     */
    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    /**
     * Set the value of curso
     */
    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get the value of tipoAtiv
     */
    public function getTipoAtiv(): ?TipoAtiv
    {
        return $this->tipoAtiv;
    }

    /**
     * Set the value of tipoAtiv
     */
    public function setTipoAtiv(?TipoAtiv $tipoAtiv): self
    {
        $this->tipoAtiv = $tipoAtiv;

        return $this;
    }

    /**
     * Get the value of codigo
     */
    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     */
    public function setCodigo(?int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }
}

?>