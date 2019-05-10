<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonalityRepository")
 * Class Seasonality
 * @package App\Entity
 */
class Seasonality
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $january;

    /**
     * @ORM\Column(type="float")
     */
    private $february;

    /**
     * @ORM\Column(type="float")
     */
    private $march;

    /**
     * @ORM\Column(type="float")
     */
    private $april;

    /**
     * @ORM\Column(type="float")
     */
    private $may;

    /**
     * @ORM\Column(type="float")
     */
    private $june;

    /**
     * @ORM\Column(type="float")
     */
    private $july;

    /**
     * @ORM\Column(type="float")
     */
    private $august;

    /**
     * @ORM\Column(type="float")
     */
    private $september;

    /**
     * @ORM\Column(type="float")
     */
    private $october;

    /**
     * @ORM\Column(type="float")
     */
    private $november;

    /**
     * @ORM\Column(type="float")
     */
    private $december;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="seasonality")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJanuary(): ?float
    {
        return $this->january;
    }

    public function setJanuary(float $january): self
    {
        $this->january = $january;

        return $this;
    }

    public function getFebruary(): ?float
    {
        return $this->february;
    }

    public function setFebruary(float $february): self
    {
        $this->february = $february;

        return $this;
    }

    public function getMarch(): ?float
    {
        return $this->march;
    }

    public function setMarch(float $march): self
    {
        $this->march = $march;

        return $this;
    }

    public function getApril(): ?float
    {
        return $this->april;
    }

    public function setApril(float $april): self
    {
        $this->april = $april;

        return $this;
    }

    public function getMay(): ?float
    {
        return $this->may;
    }

    public function setMay(float $may): self
    {
        $this->may = $may;

        return $this;
    }

    public function getJune(): ?float
    {
        return $this->june;
    }

    public function setJune(float $june): self
    {
        $this->june = $june;

        return $this;
    }

    public function getJuly(): ?float
    {
        return $this->july;
    }

    public function setJuly(float $july): self
    {
        $this->july = $july;

        return $this;
    }

    public function getAugust(): ?float
    {
        return $this->august;
    }

    public function setAugust(float $august): self
    {
        $this->august = $august;

        return $this;
    }

    public function getSeptember(): ?float
    {
        return $this->september;
    }

    public function setSeptember(float $september): self
    {
        $this->september = $september;

        return $this;
    }

    public function getOctober(): ?float
    {
        return $this->october;
    }

    public function setOctober(float $october): self
    {
        $this->october = $october;

        return $this;
    }

    public function getNovember(): ?float
    {
        return $this->november;
    }

    public function setNovember(float $november): self
    {
        $this->november = $november;

        return $this;
    }

    public function getDecember(): ?float
    {
        return $this->december;
    }

    public function setDecember(float $december): self
    {
        $this->december = $december;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSeasonality($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getSeasonality() === $this) {
                $product->setSeasonality(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return "Season ".$this->getId();
    }
}
