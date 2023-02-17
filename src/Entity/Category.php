<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $namecate;

    #[ORM\OneToMany(mappedBy: 'categorys', targetEntity: Product::class, orphanRemoval: true)]
    private $categoryy;

    public function __construct()
    {
        $this->categoryy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamecate(): ?string
    {
        return $this->namecate;
    }

    public function setNamecate(string $namecate): self
    {
        $this->namecate = $namecate;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getCategoryy(): Collection
    {
        return $this->categoryy;
    }

    public function addCategoryy(Product $categoryy): self
    {
        if (!$this->categoryy->contains($categoryy)) {
            $this->categoryy[] = $categoryy;
            $categoryy->setCategorys($this);
        }

        return $this;
    }

    public function removeCategoryy(Product $categoryy): self
    {
        if ($this->categoryy->removeElement($categoryy)) {
            // set the owning side to null (unless already changed)
            if ($categoryy->getCategorys() === $this) {
                $categoryy->setCategorys(null);
            }
        }

        return $this;
    }
}
