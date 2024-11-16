<?php

namespace App\Entity;

use App\Repository\PedidoCallCenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PedidoCallCenterRepository::class)
 */
class PedidoCallCenter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cuentaCliente;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombreCliente;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $contacto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono1;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cif;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $localidad;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min = 17, max = 17, exactMessage="El VIN debe contener {{ limit }} dígitos")
     */
    private $vin;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $marca;

    /**
     * @ORM\Column(type="integer")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=PedidoItems::class, mappedBy="PedidoCallCenter")
     */
    private $pedidoItems;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class, inversedBy="pedidoCallCenters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    public function __construct()
    {
        $this->pedidoItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCuentaCliente(): ?string
    {
        return $this->cuentaCliente;
    }

    public function setCuentaCliente(string $cuentaCliente): self
    {
        $this->cuentaCliente = $cuentaCliente;

        return $this;
    }

    public function getNombreCliente(): ?string
    {
        return $this->nombreCliente;
    }

    public function setNombreCliente(string $nombreCliente): self
    {
        $this->nombreCliente = strtoupper($nombreCliente);

        return $this;
    }

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(?string $contacto): self
    {
        $this->contacto = strtoupper($contacto);

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTelefono1(): ?int
    {
        return $this->telefono1;
    }

    public function setTelefono1(?int $telefono1): self
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    public function getCif(): ?string
    {
        return $this->cif;
    }

    public function setCif(string $cif): self
    {
        $this->cif = $cif;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): self
    {
        $this->vin = strtoupper($vin);

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection|PedidoItems[]
     */
    public function getPedidoItems(): Collection
    {
        return $this->pedidoItems;
    }

    public function addPedidoItem(PedidoItems $pedidoItem): self
    {
        if (!$this->pedidoItems->contains($pedidoItem)) {
            $this->pedidoItems[] = $pedidoItem;
            $pedidoItem->setPedidoCallCenter($this);
        }

        return $this;
    }

    public function removePedidoItem(PedidoItems $pedidoItem): self
    {
        // set the owning side to null (unless already changed)
        if ($this->pedidoItems->removeElement($pedidoItem) && $pedidoItem->getPedidoCallCenter() === $this) {
            $pedidoItem->setPedidoCallCenter(null);
        }

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }
}
