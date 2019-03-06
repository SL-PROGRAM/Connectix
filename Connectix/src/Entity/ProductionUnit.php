<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionUnitRepository")
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
}
