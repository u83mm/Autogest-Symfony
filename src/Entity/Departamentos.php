<?php

namespace App\Entity;

use App\Repository\DepartamentosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartamentosRepository::class)]
class Departamentos
{   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
   
    #[ORM\Column(type: "string", length: 50)]
    private $nombreDepartamento;
    
    #[ORM\Column(type: "string", length: 50)]
    private $role;      

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreDepartamento(): ?string
    {
        return $this->nombreDepartamento;
    }

    public function setNombreDepartamento(string $nombreDepartamento): self
    {
        $this->nombreDepartamento = $nombreDepartamento;

        return $this;
    }           

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }    
}
