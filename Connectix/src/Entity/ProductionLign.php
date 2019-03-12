<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductionUnit", inversedBy="productionLignes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionUnit;

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

    public function getProductionUnit(): ?ProductionUnit
    {
        return $this->productionUnit;
    }

    public function setProductionUnit(?ProductionUnit $productionUnit): self
    {
        $this->productionUnit = $productionUnit;

        return $this;
    }
}
