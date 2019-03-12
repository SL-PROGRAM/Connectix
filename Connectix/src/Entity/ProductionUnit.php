<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionUnitRepository")
 * @ORM\InheritanceType("JOINED")
 */
abstract class ProductionUnit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $turnCreation;

    /**
     * @ORM\Column(type="integer")
     */
    private $creationCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $maintenanceCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $administrationCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $amortizationTurn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="ProductionUnits")
     */
    private $socity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Factory", mappedBy="productionUnit", orphanRemoval=true)
     */
    private $factories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductionLign", mappedBy="productionUnit", orphanRemoval=true)
     */
    private $productionLignes;

    public function __construct()
    {
        $this->factories = new ArrayCollection();
        $this->productionLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTurnCreation(): ?int
    {
        return $this->turnCreation;
    }

    public function setTurnCreation(int $turnCreation): self
    {
        $this->turnCreation = $turnCreation;

        return $this;
    }

    public function getCreationCost(): ?int
    {
        return $this->creationCost;
    }

    public function setCreationCost(int $creationCost): self
    {
        $this->creationCost = $creationCost;

        return $this;
    }

    public function getMaintenanceCost(): ?int
    {
        return $this->maintenanceCost;
    }

    public function setMaintenanceCost(int $maintenanceCost): self
    {
        $this->maintenanceCost = $maintenanceCost;

        return $this;
    }

    public function getAdministrationCost(): ?int
    {
        return $this->administrationCost;
    }

    public function setAdministrationCost(int $administrationCost): self
    {
        $this->administrationCost = $administrationCost;

        return $this;
    }

    public function getAmortizationTurn(): ?int
    {
        return $this->amortizationTurn;
    }

    public function setAmortizationTurn(int $amortizationTurn): self
    {
        $this->amortizationTurn = $amortizationTurn;

        return $this;
    }

    public function getSocity(): ?Socity
    {
        return $this->socity;
    }

    public function setSocity(?Socity $socity): self
    {
        $this->socity = $socity;

        return $this;
    }

    /**
     * @return Collection|Factory[]
     */
    public function getFactories(): Collection
    {
        return $this->factories;
    }

    public function addFactory(Factory $factory): self
    {
        if (!$this->factories->contains($factory)) {
            $this->factories[] = $factory;
            $factory->setProductionUnit($this);
        }

        return $this;
    }

    public function removeFactory(Factory $factory): self
    {
        if ($this->factories->contains($factory)) {
            $this->factories->removeElement($factory);
            // set the owning side to null (unless already changed)
            if ($factory->getProductionUnit() === $this) {
                $factory->setProductionUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductionLign[]
     */
    public function getProductionLignes(): Collection
    {
        return $this->productionLignes;
    }

    public function addProductionLigne(ProductionLign $productionLigne): self
    {
        if (!$this->productionLignes->contains($productionLigne)) {
            $this->productionLignes[] = $productionLigne;
            $productionLigne->setProductionUnit($this);
        }

        return $this;
    }

    public function removeProductionLigne(ProductionLign $productionLigne): self
    {
        if ($this->productionLignes->contains($productionLigne)) {
            $this->productionLignes->removeElement($productionLigne);
            // set the owning side to null (unless already changed)
            if ($productionLigne->getProductionUnit() === $this) {
                $productionLigne->setProductionUnit(null);
            }
        }

        return $this;
    }
}
