<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 */
class Cliente
{	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $razonSocial;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $apellido1;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $apellido2;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $tipoVia;

    /**
     * @ORM\Column(type="string", length=60)     
     */
    private $nombreVia;

    /**
     * @ORM\Column(type="string", length=5)     
     * @Assert\Length(min = 5, max = 5, exactMessage = "El código postal debe contener {{ limit }} caracteres.",) 
     */
    private $codigoPostal;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $numVia;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $puerta;

    /**
     * @ORM\Column(type="string", length=60)     
     */
    private $localidad;

    /**
     * @ORM\Column(type="string", length=60)     
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $tfno;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Email( message = "El email {{ value }} no es un email válido.")       
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     * @Assert\Length(min=9, max = 9, exactMessage = "El C.I.F debe contener {{ limit }} caracteres.",)    
     */
    private $cif;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaAlta;

    /**
     * @ORM\OneToMany(targetEntity=PedidoCallCenter::class, mappedBy="cliente")
     */
    private $pedidoCallCenters;

    public function __construct()
    {
        $this->pedidoCallCenters = new ArrayCollection();
    }                      

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function setRazonSocial(?string $razonSocial): self
    {
        $this->razonSocial = strtoupper($razonSocial);

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = strtoupper($nombre);

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(?string $apellido1): self
    {
        $this->apellido1 = strtoupper($apellido1);

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(?string $apellido2): self
    {
        $this->apellido2 = strtoupper($apellido2);

        return $this;
    }

    public function getTipoVia(): ?string
    {
        return $this->tipoVia;
    }

    public function setTipoVia(string $tipoVia): self
    {
        $this->tipoVia = $tipoVia;

        return $this;
    }

    public function getNombreVia(): ?string
    {
        return $this->nombreVia;
    }

    public function setNombreVia(string $nombreVia): self
    {
        $this->nombreVia = strtoupper($nombreVia);

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getNumVia(): ?string
    {
        return $this->numVia;
    }

    public function setNumVia(?string $numVia): self
    {
        $this->numVia = $numVia;

        return $this;
    }

    public function getPuerta(): ?string
    {
        return $this->puerta;
    }

    public function setPuerta(?string $puerta): self
    {
        $this->puerta = $puerta;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = strtoupper($localidad);

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = strtoupper($provincia);

        return $this;
    }

    public function getTfno(): ?string
    {
        return $this->tfno;
    }

    public function setTfno(?string $tfno): self
    {
        $this->tfno = $tfno;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCif(): ?string
    {
        return $this->cif;
    }

    public function setCif(string $cif): self
    {
        $this->cif = strtoupper($cif);

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fechaAlta;
    }       

    public function setFechaAlta(\DateTimeInterface $fechaAlta): self
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * @return Collection<int, PedidoCallCenter>
     */
    public function getPedidoCallCenters(): Collection
    {
        return $this->pedidoCallCenters;
    }

    public function addPedidoCallCenter(PedidoCallCenter $pedidoCallCenter): self
    {
        if (!$this->pedidoCallCenters->contains($pedidoCallCenter)) {
            $this->pedidoCallCenters[] = $pedidoCallCenter;
            $pedidoCallCenter->setCliente($this);
        }

        return $this;
    }

    public function removePedidoCallCenter(PedidoCallCenter $pedidoCallCenter): self
    {
        if ($this->pedidoCallCenters->removeElement($pedidoCallCenter)) {
            // set the owning side to null (unless already changed)
            if ($pedidoCallCenter->getCliente() === $this) {
                $pedidoCallCenter->setCliente(null);
            }
        }

        return $this;
    }
}
