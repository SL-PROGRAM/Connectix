<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="integer", nullable=true)
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
    private $productionActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $researchCost;

    /**
     * @ORM\Column(type="integer")
     * @see(type 1 = professional, type 2 = particular)
     */
    private $productSaleType;

    /**
     * @ORM\Column(type="integer")
     */
    private $ProductMaxNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductLife", mappedBy="product", orphanRemoval=true)
     */
    private $ProductLifes;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceDiscount;

    /**
     * @ORM\Column(type="integer")
     */
    private $productAlreadySales;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Seasonality", inversedBy="products")
     */
    private $seasonality;

    /**
     * @ORM\Column(type="integer")
     */
    private $rowMaterialCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $manpowerCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $productiorTimeCost;


    public function __construct()
    {
        $this->ProductLifes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTechnologicLevel(): ?int
    {
        return $this->technologicLevel;
    }

    /**
     * @param int $technologicLevel
     * @return Product
     */
    public function setTechnologicLevel(int $technologicLevel): self
    {
        $this->technologicLevel = $technologicLevel;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getBuyPrice(): ?int
    {
        return $this->buyPrice;
    }

    /**
     * @param int $buyPrice
     * @return Product
     */
    public function setBuyPrice(int $buyPrice): self
    {
        $this->buyPrice = $buyPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSalePrice(): ?int
    {
        return $this->salePrice;
    }

    /**
     * @param int $salePrice
     * @return Product
     */
    public function setSalePrice(int $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantityDiscount(): ?int
    {
        return $this->quantityDiscount;
    }

    /**
     * @param int $quantityDiscount
     * @return Product
     */
    public function setQuantityDiscount(int $quantityDiscount): self
    {
        $this->quantityDiscount = $quantityDiscount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductionActivityCost(): ?int
    {
        return $this->productionActivityCost;
    }

    /**
     * @param int $productionActivityCost
     * @return Product
     */
    public function setProductionActivityCost(int $productionActivityCost): self
    {
        $this->productionActivityCost = $productionActivityCost;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getResearchCost(): ?int
    {
        return $this->researchCost;
    }

    /**
     * @param int $researchCost
     * @return Product
     */
    public function setResearchCost(int $researchCost): self
    {
        $this->researchCost = $researchCost;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductSaleType(): ?int
    {
        return $this->productSaleType;
    }

    /**
     * @param int $productSaleType
     * @return Product
     */
    public function setProductSaleType(int $productSaleType): self
    {
        $this->productSaleType = $productSaleType;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductMaxNumber(): ?int
    {
        return $this->ProductMaxNumber;
    }

    /**
     * @param int $ProductMaxNumber
     * @return Product
     */
    public function setProductMaxNumber(int $ProductMaxNumber): self
    {
        $this->ProductMaxNumber = $ProductMaxNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceDiscount(): ?int
    {
        return $this->priceDiscount;
    }

    /**
     * @param int $priceDiscount
     * @return Product
     */
    public function setPriceDiscount(int $priceDiscount): self
    {
        $this->priceDiscount = $priceDiscount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductAlreadySales(): ?int
    {
        return $this->productAlreadySales;
    }

    /**
     * @param int $productAlreadySales
     * @return Product
     */
    public function setProductAlreadySales(int $productAlreadySales): self
    {
        $this->productAlreadySales = $productAlreadySales;

        return $this;
    }

    /**
     * @return Collection|ProductLife[]
     */
    public function getProductLifes(): Collection
    {
        return $this->ProductLifes;
    }

    /**
     * @param ProductLife $productLife
     * @return Product
     */
    public function addProductLife(ProductLife $productLife): self
    {
        if (!$this->ProductLifes->contains($productLife)) {
            $this->ProductLifes[] = $productLife;
            $productLife->setProduct($this);
        }

        return $this;
    }

    /**
     * @param ProductLife $productLife
     * @return Product
     */
    public function removeProductLife(ProductLife $productLife): self
    {
        if ($this->ProductLifes->contains($productLife)) {
            $this->ProductLifes->removeElement($productLife);
            // set the owning side to null (unless already changed)
            if ($productLife->getProduct() === $this) {
                $productLife->setProduct(null);
            }
        }

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getSeasonality(): ?Seasonality
    {
        return $this->seasonality;
    }

    public function setSeasonality(?Seasonality $seasonality): self
    {
        $this->seasonality = $seasonality;

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

    public function getManpowerCost(): ?int
    {
        return $this->manpowerCost;
    }

    public function setManpowerCost(int $manpowerCost): self
    {
        $this->manpowerCost = $manpowerCost;

        return $this;
    }

    public function getProductiorTimeCost(): ?int
    {
        return $this->productiorTimeCost;
    }

    public function setProductiorTimeCost(int $productiorTimeCost): self
    {
        $this->productiorTimeCost = $productiorTimeCost;

        return $this;
    }

    public  function __toString()
    {
        return $this->getName();
    }

}
