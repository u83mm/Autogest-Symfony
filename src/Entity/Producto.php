<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
   
    #[ORM\Column(type:"string", length: 20, unique: true)]
    private $referencia;
    
    #[ORM\Column(type:"string", length: 50)]
    private $descripcion;
   
    #[ORM\Column(type:"string", length: 20)]
    private $familia;
    
    #[ORM\Column(type: "decimal", precision: 9, scale: 2)]
    private $pvp;
   
    #[ORM\Column(type:"smallint")]
    private $marca;
   
    #[ORM\OneToOne(targetEntity: Stock::class, inversedBy: "producto", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(nullable: false)]
    private $stock;        

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(string $referencia): self
    {
        $this->referencia = strtoupper($referencia);

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = strtoupper($descripcion);

        return $this;
    }

    public function getFamilia(): ?string
    {
        return $this->familia;
    }

    public function setFamilia(string $familia): self
    {
        $this->familia = $familia;

        return $this;
    }

    public function getPvp(): ?string
    {
        return $this->pvp;
    }

    public function setPvp(string $pvp): self
    {
        $this->pvp = $pvp;

        return $this;
    }

    public function getMarca(): ?int
    {
        return $this->marca;
    }

    public function setMarca(int $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }    
}
