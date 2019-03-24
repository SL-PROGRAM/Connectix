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
     * @ORM\JoinColumn(nullable=false)
     */
    private $socity;


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

}
