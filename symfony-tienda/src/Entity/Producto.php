<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Tieneque tener un nombre del producto!')]
    #[ORM\Column(length: 255)]
    private ?string $producto = null;

    #[Assert\NotBlank(message: 'Tiene que tener un modelo!')]
    #[ORM\Column(length: 255)]
    private ?string $modelo = null;

    #[ORM\Column(length: 255)]
    private ?string $caracteristicas = null;

    #[Assert\NotBlank(message: 'Tiene que tener un precio!')]
    #[ORM\Column(length: 255)]
    private ?string $precio = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tienda $tienda = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?string
    {
        return $this->producto;
    }

    public function setProducto(string $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getCaracteristicas(): ?string
    {
        return $this->caracteristicas;
    }

    public function setCaracteristicas(string $caracteristicas): self
    {
        $this->caracteristicas = $caracteristicas;

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

    public function getTienda(): ?Tienda
    {
        return $this->tienda;
    }

    public function setTienda(?Tienda $tienda): self
    {
        $this->tienda = $tienda;

        return $this;
    }
}
