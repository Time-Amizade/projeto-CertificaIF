<?php

class TipoAtiv implements JsonSerializable{

    private ?int $id;
    private ?string $nomeAtiv;
    private ?string $descAtiv;

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'nomeAtiv' => $this->nomeAtiv,
            'descAtiv' => $this->descAtiv
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
     * Get the value of nomeAtiv
     */
    public function getNomeAtiv(): ?string
    {
        return $this->nomeAtiv;
    }

    /**
     * Set the value of nomeAtiv
     */
    public function setNomeAtiv(?string $nomeAtiv): self
    {
        $this->nomeAtiv = $nomeAtiv;

        return $this;
    }

    /**
     * Get the value of descAtiv
     */
    public function getDescAtiv(): ?string
    {
        return $this->descAtiv;
    }

    /**
     * Set the value of descAtiv
     */
    public function setDescAtiv(?string $descAtiv): self
    {
        $this->descAtiv = $descAtiv;

        return $this;
    }
}

?>