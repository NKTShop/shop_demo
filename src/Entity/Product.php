<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $namep;

    #[ORM\Column(type: 'float')]
    private $pricep;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'float')]
    private $quantity;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryy')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorys;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamep(): ?string
    {
        return $this->namep;
    }

    public function setNamep(string $namep): self
    {
        $this->namep = $namep;

        return $this;
    }

    public function getPricep(): ?float
    {
        return $this->pricep;
    }

    public function setPricep(float $pricep): self
    {
        $this->pricep = $pricep;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorys(): ?Category
    {
        return $this->categorys;
    }

    public function setCategorys(?Category $categorys): self
    {
        $this->categorys = $categorys;

        return $this;
    }
}
