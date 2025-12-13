<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
  
    #[ORM\Column(type:"smallint")]
    private $almacen;
   
    #[ORM\Column(type:"smallint")]
    private $marca;
 
    #[ORM\Column(type: "string", length: 20, unique: true)]
    private $referencia;
    
    #[ORM\Column(type: "decimal", precision: 9, scale: 2)]
    private $cantidad;
  
    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private $ubicacion;
   
    #[ORM\OneToOne(targetEntity: Producto::class, mappedBy: "stock", cascade: ["persist", "remove"])]
    private $producto;       

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlmacen(): ?int
    {
        return $this->almacen;
    }

    public function setAlmacen(int $almacen): self
    {
        $this->almacen = $almacen;

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

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(string $referencia): self
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(string $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getUbicacion(): ?string
    {
        return $this->ubicacion;
    }

    public function setUbicacion(?string $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(Producto $producto): self
    {
        // set the owning side of the relation if necessary
        if ($producto->getStock() !== $this) {
            $producto->setStock($this);
        }

        $this->producto = $producto;

        return $this;
    }    
}
