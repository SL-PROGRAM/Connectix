<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BalanceSheetRepository")
 */
class BalanceSheet
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
    private $turn;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $administationActivityCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $researchActivityCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityProfessionalCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityParticularCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionActivityCapacity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="balanceSheets")
     */
    private $socity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAdministationActivityCapacity(): ?int
    {
        return $this->administationActivityCapacity;
    }

    public function setAdministationActivityCapacity(int $administationActivityCapacity): self
    {
        $this->administationActivityCapacity = $administationActivityCapacity;

        return $this;
    }

    public function getSalesActivityCapacity(): ?int
    {
        return $this->salesActivityCapacity;
    }

    public function setSalesActivityCapacity(int $salesActivityCapacity): self
    {
        $this->salesActivityCapacity = $salesActivityCapacity;

        return $this;
    }

    public function getResearchActivityCapacity(): ?int
    {
        return $this->researchActivityCapacity;
    }

    public function setResearchActivityCapacity(int $researchActivityCapacity): self
    {
        $this->researchActivityCapacity = $researchActivityCapacity;

        return $this;
    }

    public function getSalesActivityProfessionalCapacity(): ?int
    {
        return $this->salesActivityProfessionalCapacity;
    }

    public function setSalesActivityProfessionalCapacity(int $salesActivityProfessionalCapacity): self
    {
        $this->salesActivityProfessionalCapacity = $salesActivityProfessionalCapacity;

        return $this;
    }

    public function getSalesActivityParticularCapacity(): ?int
    {
        return $this->salesActivityParticularCapacity;
    }

    public function setSalesActivityParticularCapacity(int $salesActivityParticularCapacity): self
    {
        $this->salesActivityParticularCapacity = $salesActivityParticularCapacity;

        return $this;
    }

    public function getProductionActivityCapacity(): ?int
    {
        return $this->productionActivityCapacity;
    }

    public function setProductionActivityCapacity(int $productionActivityCapacity): self
    {
        $this->productionActivityCapacity = $productionActivityCapacity;

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
