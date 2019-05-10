<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactoryRepository")
 * Class Factory
 * @package App\Entity
 */
class Factory extends ProductionUnit
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductionLign", mappedBy="factory", orphanRemoval=true)
     */
    private $ProductionLign;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;


    public function __construct()
    {
        $this->ProductionLign = new ArrayCollection();
    }


    /**
     * @return Collection|ProductionLign[]
     */
    public function getProductionLign(): Collection
    {
        return $this->ProductionLign;
    }

    public function addProductionLign(ProductionLign $productionLign): self
    {
        if (!$this->ProductionLign->contains($productionLign)) {
            $this->ProductionLign[] = $productionLign;
            $productionLign->setFactory($this);
        }

        return $this;
    }

    public function removeProductionLign(ProductionLign $productionLign): self
    {
        if ($this->ProductionLign->contains($productionLign)) {
            $this->ProductionLign->removeElement($productionLign);
            // set the owning side to null (unless already changed)
            if ($productionLign->getFactory() === $this) {
                $productionLign->setFactory(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
