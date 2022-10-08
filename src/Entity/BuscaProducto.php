<?php

namespace App\Entity;

use App\Repository\BuscaProductoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuscaProductoRepository::class)
 */
class BuscaProducto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $selecciona;

    /**
     * @ORM\Column(type="string", length=50)
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

    public function setSelecciona(string $selecciona): self
    {
        $this->selecciona = $selecciona;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
