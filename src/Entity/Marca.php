<?php

namespace App\Entity;

use App\Repository\MarcaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarcaRepository::class)]
class Marca
{  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
    
    #[ORM\Column(type: "string", length: 20)]
    private $nombre;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $logo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = strtoupper($nombre);

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
