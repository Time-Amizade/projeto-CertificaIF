<?php

class Curso implements JsonSerializable {
    private ?int $id;
    private ?string $nomeCurso = '';
    private ?int $cargaHorariaAtivComplement = null;

    // Implementação do JsonSerializable
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nomeCurso' => $this->nomeCurso,
            'cargaHorariaAtivComplement' => $this->cargaHorariaAtivComplement
        ];
    }

    // Getters e Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNomeCurso(): ?string
    {
        return $this->nomeCurso;
    }

    public function setNomeCurso(?string $nomeCurso): self
    {
        $this->nomeCurso = $nomeCurso;
        return $this;
    }

    public function getCargaHorariaAtivComplement(): ?int
    {
        return $this->cargaHorariaAtivComplement;
    }

    public function setCargaHorariaAtivComplement(?int $cargaHorariaAtivComplement): self
    {
        $this->cargaHorariaAtivComplement = $cargaHorariaAtivComplement;
        return $this;
    }
}

?>
