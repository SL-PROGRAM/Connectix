<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductLifeRepository")
 */
class ProductLife
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
    private $cycleLifeNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $productCycleLifeNumberMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $cycleDuration;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceCoeficient;

    /**
     * @ORM\Column(type="integer")
     */
    private $publicityCoeficient;

    /**
     * @ORM\Column(type="integer")
     */
    private $PriceMinPublicityImpact;

    /**
     * @ORM\Column(type="integer")
     */
    private $PriceMaxPublicityImpact;

    /**
     * @ORM\Column(type="integer")
     */
    private $quality;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="ProductLifes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCycleLifeNumber(): ?int
    {
        return $this->cycleLifeNumber;
    }

    /**
     * @param int $cycleLifeNumber
     * @return ProductLife
     */
    public function setCycleLifeNumber(int $cycleLifeNumber): self
    {
        $this->cycleLifeNumber = $cycleLifeNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductCycleLifeNumberMax(): ?int
    {
        return $this->productCycleLifeNumberMax;
    }

    /**
     * @param int $productCycleLifeNumberMax
     * @return ProductLife
     */
    public function setProductCycleLifeNumberMax(int $productCycleLifeNumberMax): self
    {
        $this->productCycleLifeNumberMax = $productCycleLifeNumberMax;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCycleDuration(): ?int
    {
        return $this->cycleDuration;
    }

    /**
     * @param int $cycleDuration
     * @return ProductLife
     */
    public function setCycleDuration(int $cycleDuration): self
    {
        $this->cycleDuration = $cycleDuration;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceCoeficient(): ?int
    {
        return $this->priceCoeficient;
    }

    /**
     * @param int $priceCoeficient
     * @return ProductLife
     */
    public function setPriceCoeficient(int $priceCoeficient): self
    {
        $this->priceCoeficient = $priceCoeficient;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPublicityCoeficient(): ?int
    {
        return $this->publicityCoeficient;
    }

    /**
     * @param int $publicityCoeficient
     * @return ProductLife
     */
    public function setPublicityCoeficient(int $publicityCoeficient): self
    {
        $this->publicityCoeficient = $publicityCoeficient;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMinPublicityImpact(): ?int
    {
        return $this->PriceMinPublicityImpact;
    }

    /**
     * @param int $PriceMinPublicityImpact
     * @return ProductLife
     */
    public function setPriceMinPublicityImpact(int $PriceMinPublicityImpact): self
    {
        $this->PriceMinPublicityImpact = $PriceMinPublicityImpact;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMaxPublicityImpact(): ?int
    {
        return $this->PriceMaxPublicityImpact;
    }

    /**
     * @param int $PriceMaxPublicityImpact
     * @return ProductLife
     */
    public function setPriceMaxPublicityImpact(int $PriceMaxPublicityImpact): self
    {
        $this->PriceMaxPublicityImpact = $PriceMaxPublicityImpact;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuality(): ?int
    {
        return $this->quality;
    }

    /**
     * @param int $quality
     * @return ProductLife
     */
    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return ProductLife
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
