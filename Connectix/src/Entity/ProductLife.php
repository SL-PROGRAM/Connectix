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
    private $priceMinPublicityImpact;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMaxPublicityImpact;

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
     * @ORM\OneToOne(targetEntity="App\Entity\ProductLife", inversedBy="ParentProductLife", cascade={"persist", "remove"})
     */
    private $subProductLife;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProductLife", mappedBy="subProductLife", cascade={"persist", "remove"})
     */
    private $ParentProductLife;


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
        return $this->priceMinPublicityImpact;
    }

    /**
     * @param int $priceMinPublicityImpact
     * @return ProductLife
     */
    public function setPriceMinPublicityImpact(int $priceMinPublicityImpact): self
    {
        $this->priceMinPublicityImpact = $priceMinPublicityImpact;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMaxPublicityImpact(): ?int
    {
        return $this->priceMaxPublicityImpact;
    }

    /**
     * @param int $priceMaxPublicityImpact
     * @return ProductLife
     */
    public function setPriceMaxPublicityImpact(int $priceMaxPublicityImpact): self
    {
        $this->priceMaxPublicityImpact = $priceMaxPublicityImpact;

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

    public function __toString()
    {
        return 'product life '.$this->getCycleLifeNumber();
    }

    public function getSubProductLife(): ?self
    {
        return $this->subProductLife;
    }

    public function setSubProductLife(?self $subProductLife): self
    {
        $this->subProductLife = $subProductLife;

        return $this;
    }

    public function getParentProductLife(): ?self
    {
        return $this->ParentProductLife;
    }

    public function setParentProductLife(?self $ParentProductLife): self
    {
        $this->ParentProductLife = $ParentProductLife;

        // set (or unset) the owning side of the relation if necessary
        $newSubProductLife = $ParentProductLife === null ? null : $this;
        if ($newSubProductLife !== $ParentProductLife->getSubProductLife()) {
            $ParentProductLife->setSubProductLife($newSubProductLife);
        }

        return $this;
    }
}
