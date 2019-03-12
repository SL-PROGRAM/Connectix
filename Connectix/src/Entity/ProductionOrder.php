<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionOrderRepository")
 */
class ProductionOrder
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
    private $quantityProductCreat;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $administrationActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $rowMaterialCost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductionLign", inversedBy="productionOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionLign;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

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

    public function getQuantityProductCreat(): ?int
    {
        return $this->quantityProductCreat;
    }

    public function setQuantityProductCreat(int $quantityProductCreat): self
    {
        $this->quantityProductCreat = $quantityProductCreat;

        return $this;
    }

    public function getProductionActivityCost(): ?int
    {
        return $this->productionActivityCost;
    }

    public function setProductionActivityCost(int $productionActivityCost): self
    {
        $this->productionActivityCost = $productionActivityCost;

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

    public function getProductionTime(): ?int
    {
        return $this->productionTime;
    }

    public function setProductionTime(int $productionTime): self
    {
        $this->productionTime = $productionTime;

        return $this;
    }

    public function getRowMaterialCost(): ?int
    {
        return $this->rowMaterialCost;
    }

    public function setRowMaterialCost(int $rowMaterialCost): self
    {
        $this->rowMaterialCost = $rowMaterialCost;

        return $this;
    }

    public function getProductionLign(): ?ProductionLign
    {
        return $this->productionLign;
    }

    public function setProductionLign(?ProductionLign $productionLign): self
    {
        $this->productionLign = $productionLign;

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
