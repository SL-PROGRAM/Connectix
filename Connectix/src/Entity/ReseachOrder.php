<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReseachOrderRepository")
 */
class ReseachOrder
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
    private $reseachDo;

    /**
     * @ORM\Column(type="integer")
     */
    private $researchActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $administrationActivityCost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="reseachOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $socity;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReseachDo(): ?int
    {
        return $this->reseachDo;
    }

    public function setReseachDo(int $reseachDo): self
    {
        $this->reseachDo = $reseachDo;

        return $this;
    }

    public function getResearchActivityCost(): ?int
    {
        return $this->researchActivityCost;
    }

    public function setResearchActivityCost(int $researchActivityCost): self
    {
        $this->researchActivityCost = $researchActivityCost;

        return $this;
    }

    public function getAdministrationActivityCost(): ?int
    {
        return $this->administrationActivityCost;
    }

    public function setAdministrationActivityCost(int $administrationActivityCost): self
    {
        $this->administrationActivityCost = $administrationActivityCost;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
