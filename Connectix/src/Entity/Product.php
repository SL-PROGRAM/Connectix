<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $technologicLevel;

    /**
     * @ORM\Column(type="integer")
     */
    private $buyPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $salePrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityDiscount;

    /**
     * @ORM\Column(type="integer")
     */
    private $productiorActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $researchCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $productSaleType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTechnologicLevel(): ?int
    {
        return $this->technologicLevel;
    }

    public function setTechnologicLevel(int $technologicLevel): self
    {
        $this->technologicLevel = $technologicLevel;

        return $this;
    }

    public function getBuyPrice(): ?int
    {
        return $this->buyPrice;
    }

    public function setBuyPrice(int $buyPrice): self
    {
        $this->buyPrice = $buyPrice;

        return $this;
    }

    public function getSalePrice(): ?int
    {
        return $this->salePrice;
    }

    public function setSalePrice(int $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getQuantityDiscount(): ?int
    {
        return $this->quantityDiscount;
    }

    public function setQuantityDiscount(int $quantityDiscount): self
    {
        $this->quantityDiscount = $quantityDiscount;

        return $this;
    }

    public function getProductiorActivityCost(): ?int
    {
        return $this->productiorActivityCost;
    }

    public function setProductiorActivityCost(int $productiorActivityCost): self
    {
        $this->productiorActivityCost = $productiorActivityCost;

        return $this;
    }

    public function getResearchCost(): ?int
    {
        return $this->researchCost;
    }

    public function setResearchCost(int $researchCost): self
    {
        $this->researchCost = $researchCost;

        return $this;
    }

    public function getProductSaleType(): ?int
    {
        return $this->productSaleType;
    }

    public function setProductSaleType(int $productSaleType): self
    {
        $this->productSaleType = $productSaleType;

        return $this;
    }
}
