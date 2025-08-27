<?php  


class Curso{
    private ?int $id;
    private ?string $nomeCurso;
    private ?int $cargaHorariaAtivComplement;


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
     * Get the value of nomeCurso
     */
    public function getNomeCurso(): ?string
    {
        return $this->nomeCurso;
    }

    /**
     * Set the value of nomeCurso
     */
    public function setNomeCurso(?string $nomeCurso): self
    {
        $this->nomeCurso = $nomeCurso;

        return $this;
    }

    /**
     * Get the value of cargaHorariaAtivComplement
     */
    public function getCargaHorariaAtivComplement(): ?int
    {
        return $this->cargaHorariaAtivComplement;
    }

    /**
     * Set the value of cargaHorariaAtivComplement
     */
    public function setCargaHorariaAtivComplement(?int $cargaHorariaAtivComplement): self
    {
        $this->cargaHorariaAtivComplement = $cargaHorariaAtivComplement;

        return $this;
    }
}





?>