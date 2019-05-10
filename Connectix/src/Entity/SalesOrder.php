<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesOrderRepository")
 * Class SalesOrder
 * @package App\Entity
 */
class SalesOrder
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
    private $salesPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQuantitySales;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityCost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="salesOrders")
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSalesPrice(): ?int
    {
        return $this->salesPrice;
    }

    public function setSalesPrice(int $salesPrice): self
    {
        $this->salesPrice = $salesPrice;

        return $this;
    }

    public function getProductQuantitySales(): ?int
    {
        return $this->productQuantitySales;
    }

    public function setProductQuantitySales(int $productQuantitySales): self
    {
        $this->productQuantitySales = $productQuantitySales;

        return $this;
    }

    public function getSalesActivityCost(): ?int
    {
        return $this->salesActivityCost;
    }

    public function setSalesActivityCost(int $salesActivityCost): self
    {
        $this->salesActivityCost = $salesActivityCost;

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
}
