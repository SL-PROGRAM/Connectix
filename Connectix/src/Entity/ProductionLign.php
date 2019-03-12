<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionLignRepository")
 */
class ProductionLign extends ProductionUnit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Factory", inversedBy="ProductionLign")
     * @ORM\JoinColumn(nullable=false)
     */
    private $factory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductionOrder", mappedBy="productionLign", orphanRemoval=true)
     */
    private $productionOrders;

    public function __construct()
    {
        $this->productionOrders = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactory(): ?Factory
    {
        return $this->factory;
    }

    public function setFactory(?Factory $factory): self
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @return Collection|ProductionOrder[]
     */
    public function getProductionOrders(): Collection
    {
        return $this->productionOrders;
    }

    public function addProductionOrder(ProductionOrder $productionOrder): self
    {
        if (!$this->productionOrders->contains($productionOrder)) {
            $this->productionOrders[] = $productionOrder;
            $productionOrder->setProductionLign($this);
        }

        return $this;
    }

    public function removeProductionOrder(ProductionOrder $productionOrder): self
    {
        if ($this->productionOrders->contains($productionOrder)) {
            $this->productionOrders->removeElement($productionOrder);
            // set the owning side to null (unless already changed)
            if ($productionOrder->getProductionLign() === $this) {
                $productionOrder->setProductionLign(null);
            }
        }

        return $this;
    }

}
