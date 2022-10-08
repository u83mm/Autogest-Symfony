<?php

namespace App\Entity;

use App\Repository\PedidoItemsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidoItemsRepository::class)
 */
class PedidoItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pedidoId;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $descripcion;

    /**
     * @ORM\Column()
     */
    private $cantidad;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $precio;

    /**
     * @ORM\Column(type="string", length=13, nullable=true)
     */
    private $referencia;

    /**
     * @ORM\Column(type="smallint")
     */
    private $stock;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $dto;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $neto;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $totalPvp;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $totalDto;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $totalNeto;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $totalIva;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=PedidoCallCenter::class, inversedBy="pedidoItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $PedidoCallCenter;
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPedidoId(): ?int
    {
        return $this->pedidoId;
    }

    public function setPedidoId(int $pedidoId): self
    {
        $this->pedidoId = $pedidoId;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(?string $referencia): self
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDto(): ?string
    {
        return $this->dto;
    }

    public function setDto(string $dto): self
    {
        $this->dto = $dto;

        return $this;
    }

    public function getNeto(): ?string
    {
        return $this->neto;
    }

    public function setNeto(string $neto): self
    {
        $this->neto = $neto;

        return $this;
    }

    public function getTotalPvp(): ?string
    {
        return $this->totalPvp;
    }

    public function setTotalPvp(string $totalPvp): self
    {
        $this->totalPvp = $totalPvp;

        return $this;
    }

    public function getTotalDto(): ?string
    {
        return $this->totalDto;
    }

    public function setTotalDto(string $totalDto): self
    {
        $this->totalDto = $totalDto;

        return $this;
    }

    public function getTotalNeto(): ?string
    {
        return $this->totalNeto;
    }

    public function setTotalNeto(string $totalNeto): self
    {
        $this->totalNeto = $totalNeto;

        return $this;
    }

    public function getTotalIva(): ?string
    {
        return $this->totalIva;
    }

    public function setTotalIva(string $totalIva): self
    {
        $this->totalIva = $totalIva;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPedidoCallCenter(): ?PedidoCallCenter
    {
        return $this->PedidoCallCenter;
    }

    public function setPedidoCallCenter(?PedidoCallCenter $PedidoCallCenter): self
    {
        $this->PedidoCallCenter = $PedidoCallCenter;

        return $this;
    }    
}
