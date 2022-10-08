<?php

namespace App\Entity;

use App\Repository\BuscaPedidoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BuscaPedidoRepository::class)
 */
class BuscaPedido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $selecciona;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Debe rellenar los campos") 
     */
    private $valor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSelecciona(): ?string
    {
        return $this->selecciona;
    }

    public function setSelecciona(?string $selecciona): self
    {
        $this->selecciona = $selecciona;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(?string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
