<?php

namespace App\Entity;

use App\Repository\FamiliaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamiliaRepository::class)]
class Familia
{  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
    
    #[ORM\Column(type: "string", length: 3)]
    private $tipo_familia;
   
    #[ORM\Column(type: "string", length:30)]
    private $nombre_familia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoFamilia(): ?string
    {
        return $this->tipo_familia;
    }

    public function setTipoFamilia(string $tipo_familia): self
    {
        $this->tipo_familia = $tipo_familia;

        return $this;
    }

    public function getNombreFamilia(): ?string
    {
        return $this->nombre_familia;
    }

    public function setNombreFamilia(string $nombre_familia): self
    {
        $this->nombre_familia = $nombre_familia;

        return $this;
    }
}
