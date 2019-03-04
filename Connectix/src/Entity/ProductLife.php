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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCycleLifeNumber(): ?int
    {
        return $this->cycleLifeNumber;
    }

    public function setCycleLifeNumber(int $cycleLifeNumber): self
    {
        $this->cycleLifeNumber = $cycleLifeNumber;

        return $this;
    }

    public function getProductCycleLifeNumberMax(): ?int
    {
        return $this->productCycleLifeNumberMax;
    }

    public function setProductCycleLifeNumberMax(int $productCycleLifeNumberMax): self
    {
        $this->productCycleLifeNumberMax = $productCycleLifeNumberMax;

        return $this;
    }

    public function getCycleDuration(): ?int
    {
        return $this->cycleDuration;
    }

    public function setCycleDuration(int $cycleDuration): self
    {
        $this->cycleDuration = $cycleDuration;

        return $this;
    }

    public function getPriceCoeficient(): ?int
    {
        return $this->priceCoeficient;
    }

    public function setPriceCoeficient(int $priceCoeficient): self
    {
        $this->priceCoeficient = $priceCoeficient;

        return $this;
    }

    public function getPublicityCoeficient(): ?int
    {
        return $this->publicityCoeficient;
    }

    public function setPublicityCoeficient(int $publicityCoeficient): self
    {
        $this->publicityCoeficient = $publicityCoeficient;

        return $this;
    }

    public function getPriceMinPublicityImpact(): ?int
    {
        return $this->PriceMinPublicityImpact;
    }

    public function setPriceMinPublicityImpact(int $PriceMinPublicityImpact): self
    {
        $this->PriceMinPublicityImpact = $PriceMinPublicityImpact;

        return $this;
    }

    public function getPriceMaxPublicityImpact(): ?int
    {
        return $this->PriceMaxPublicityImpact;
    }

    public function setPriceMaxPublicityImpact(int $PriceMaxPublicityImpact): self
    {
        $this->PriceMaxPublicityImpact = $PriceMaxPublicityImpact;

        return $this;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }
}
