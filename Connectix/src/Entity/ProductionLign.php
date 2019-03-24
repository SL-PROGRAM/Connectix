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
     * @ORM\ManyToOne(targetEntity="App\Entity\Factory", inversedBy="ProductionLign")
     * @ORM\JoinColumn(nullable=false)
     */
    private $factory;


    /**
     * @ORM\Column(type="integer")
     */
    private $annualProductTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalLifeProductTime;


    public function getFactory(): ?Factory
    {
        return $this->factory;
    }

    public function setFactory(?Factory $factory): self
    {
        $this->factory = $factory;

        return $this;
    }

    public function getAnnualProductTime(): ?int
    {
        return $this->annualProductTime;
    }

    public function setAnnualProductTime(int $annualProductTime): self
    {
        $this->annualProductTime = $annualProductTime;

        return $this;
    }

    public function getTotalLifeProductTime(): ?int
    {
        return $this->totalLifeProductTime;
    }

    public function setTotalLifeProductTime(int $totalLifeProductTime): self
    {
        $this->totalLifeProductTime = $totalLifeProductTime;

        return $this;
    }


}
