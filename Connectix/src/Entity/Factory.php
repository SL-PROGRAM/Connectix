<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactoryRepository")
 */
class Factory extends ProductionUnit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductionLign", mappedBy="factory", orphanRemoval=true)
     */
    private $ProductionLign;

    public function __construct()
    {
        $this->ProductionLign = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
