<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseOrderRepository")
 * Class PurchaseOrder
 * @package App\Entity
 */
class PurchaseOrder
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
    private $productQuantityPurchase;

    /**
     * @ORM\Column(type="integer")
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $purchaseActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="purchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $socity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
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

    public function getProductQuantityPurchase(): ?int
    {
        return $this->productQuantityPurchase;
    }

    public function setProductQuantityPurchase(int $productQuantityPurchase): self
    {
        $this->productQuantityPurchase = $productQuantityPurchase;

        return $this;
    }

    public function getPurchasePrice(): ?int
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(int $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getPurchaseActivityCost(): ?int
    {
        return $this->purchaseActivityCost;
    }

    public function setPurchaseActivityCost(int $purchaseActivityCost): self
    {
        $this->purchaseActivityCost = $purchaseActivityCost;

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

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function __toString()
    {
        return 'Purchase Order';
    }
}
