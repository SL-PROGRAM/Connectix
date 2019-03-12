<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
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
    private $tva;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxturn;

    /**
     * @ORM\Column(type="integer")
     */
    private $turn;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $smic;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="game", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Socity", mappedBy="game", orphanRemoval=true)
     */
    private $socities;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMinLvl1;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMaxLvl1;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMinLvl2;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMinLvl3;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMinLvl4;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMaxLvl2;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMaxLvl3;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMaxLvl4;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMinLvl1;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMinLvl2;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMinLvl3;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMinLvl4;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMaxLvl1;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMaxLvl2;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMaxLvl3;

    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMaxLvl4;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife1;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife2;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife3;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife4;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife1;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife2;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife3;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife4;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife1;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife2;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife3;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife4;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife1;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife2;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife3;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife4;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="game")
     */
    private $users;

    /**
     * Game constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->socities = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Game
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTva(): ?int
    {
        return $this->tva;
    }

    /**
     * @param int $tva
     * @return Game
     */
    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxturn(): ?int
    {
        return $this->maxturn;
    }

    /**
     * @param int $maxturn
     * @return Game
     */
    public function setMaxturn(int $maxturn): self
    {
        $this->maxturn = $maxturn;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTurn(): ?int
    {
        return $this->turn;
    }

    /**
     * @param int $turn
     * @return Game
     */
    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSocityNumber(): ?int
    {
        return $this->socityNumber;
    }

    /**
     * @param int $socityNumber
     * @return Game
     */
    public function setSocityNumber(int $socityNumber): self
    {
        $this->socityNumber = $socityNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSmic(): ?int
    {
        return $this->smic;
    }

    /**
     * @param int $smic
     * @return Game
     */
    public function setSmic(int $smic): self
    {
        $this->smic = $smic;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    /**
     * @param \DateTimeInterface $creatAt
     * @return Game
     */
    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }

    /**
     * @return Collection|product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return Game
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setGame($this);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return Game
     */
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getGame() === $this) {
                $product->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Socity[]
     */
    public function getSocities(): Collection
    {
        return $this->socities;
    }

    /**
     * @param Socity $socity
     * @return Game
     */
    public function addSocity(Socity $socity): self
    {
        if (!$this->socities->contains($socity)) {
            $this->socities[] = $socity;
            $socity->setGame($this);
        }

        return $this;
    }

    /**
     * @param Socity $socity
     * @return Game
     */
    public function removeSocity(Socity $socity): self
    {
        if ($this->socities->contains($socity)) {
            $this->socities->removeElement($socity);
            // set the owning side to null (unless already changed)
            if ($socity->getGame() === $this) {
                $socity->setGame(null);
            }
        }

        return $this;
    }

    public function getSalesPriceMinLvl1(): ?int
    {
        return $this->salesPriceMinLvl1;
    }

    public function setSalesPriceMinLvl1(int $salesPriceMinLvl1): self
    {
        $this->salesPriceMinLvl1 = $salesPriceMinLvl1;

        return $this;
    }

    public function getSalesPriceMaxLvl1(): ?int
    {
        return $this->salesPriceMaxLvl1;
    }

    public function setSalesPriceMaxLvl1(int $salesPriceMaxLvl1): self
    {
        $this->salesPriceMaxLvl1 = $salesPriceMaxLvl1;

        return $this;
    }

    public function getSalesPriceMinLvl2(): ?int
    {
        return $this->salesPriceMinLvl2;
    }

    public function setSalesPriceMinLvl2(int $salesPriceMinLvl2): self
    {
        $this->salesPriceMinLvl2 = $salesPriceMinLvl2;

        return $this;
    }

    public function getSalesPriceMinLvl3(): ?int
    {
        return $this->salesPriceMinLvl3;
    }

    public function setSalesPriceMinLvl3(int $salesPriceMinLvl3): self
    {
        $this->salesPriceMinLvl3 = $salesPriceMinLvl3;

        return $this;
    }

    public function getSalesPriceMinLvl4(): ?int
    {
        return $this->salesPriceMinLvl4;
    }

    public function setSalesPriceMinLvl4(int $salesPriceMinLvl4): self
    {
        $this->salesPriceMinLvl4 = $salesPriceMinLvl4;

        return $this;
    }

    public function getSalesPriceMaxLvl2(): ?int
    {
        return $this->salesPriceMaxLvl2;
    }

    public function setSalesPriceMaxLvl2(int $salesPriceMaxLvl2): self
    {
        $this->salesPriceMaxLvl2 = $salesPriceMaxLvl2;

        return $this;
    }

    public function getSalesPriceMaxLvl3(): ?int
    {
        return $this->salesPriceMaxLvl3;
    }

    public function setSalesPriceMaxLvl3(int $salesPriceMaxLvl3): self
    {
        $this->salesPriceMaxLvl3 = $salesPriceMaxLvl3;

        return $this;
    }

    public function getSalesPriceMaxLvl4(): ?int
    {
        return $this->salesPriceMaxLvl4;
    }

    public function setSalesPriceMaxLvl4(int $salesPriceMaxLvl4): self
    {
        $this->salesPriceMaxLvl4 = $salesPriceMaxLvl4;

        return $this;
    }

    public function getProductNumberMinLvl1(): ?int
    {
        return $this->productNumberMinLvl1;
    }

    public function setProductNumberMinLvl1(int $productNumberMinLvl1): self
    {
        $this->productNumberMinLvl1 = $productNumberMinLvl1;

        return $this;
    }

    public function getProductNumberMinLvl2(): ?int
    {
        return $this->productNumberMinLvl2;
    }

    public function setProductNumberMinLvl2(int $productNumberMinLvl2): self
    {
        $this->productNumberMinLvl2 = $productNumberMinLvl2;

        return $this;
    }

    public function getProductNumberMinLvl3(): ?int
    {
        return $this->productNumberMinLvl3;
    }

    public function setProductNumberMinLvl3(int $productNumberMinLvl3): self
    {
        $this->productNumberMinLvl3 = $productNumberMinLvl3;

        return $this;
    }

    public function getProductNumberMinLvl4(): ?int
    {
        return $this->productNumberMinLvl4;
    }

    public function setProductNumberMinLvl4(int $productNumberMinLvl4): self
    {
        $this->productNumberMinLvl4 = $productNumberMinLvl4;

        return $this;
    }

    public function getProductNumberMaxLvl1(): ?int
    {
        return $this->productNumberMaxLvl1;
    }

    public function setProductNumberMaxLvl1(int $productNumberMaxLvl1): self
    {
        $this->productNumberMaxLvl1 = $productNumberMaxLvl1;

        return $this;
    }

    public function getProductNumberMaxLvl2(): ?int
    {
        return $this->productNumberMaxLvl2;
    }

    public function setProductNumberMaxLvl2(int $productNumberMaxLvl2): self
    {
        $this->productNumberMaxLvl2 = $productNumberMaxLvl2;

        return $this;
    }

    public function getProductNumberMaxLvl3(): ?int
    {
        return $this->productNumberMaxLvl3;
    }

    public function setProductNumberMaxLvl3(int $productNumberMaxLvl3): self
    {
        $this->productNumberMaxLvl3 = $productNumberMaxLvl3;

        return $this;
    }

    public function getProductNumberMaxLvl4(): ?int
    {
        return $this->productNumberMaxLvl4;
    }

    public function setProductNumberMaxLvl4(int $productNumberMaxLvl4): self
    {
        $this->productNumberMaxLvl4 = $productNumberMaxLvl4;

        return $this;
    }

    public function getPercentProductAvailableMinCycleLife1(): ?int
    {
        return $this->percentProductAvailableMinCycleLife1;
    }

    public function setPercentProductAvailableMinCycleLife1(int $percentProductAvailableMinCycleLife1): self
    {
        $this->percentProductAvailableMinCycleLife1 = $percentProductAvailableMinCycleLife1;

        return $this;
    }

    public function getPercentProductAvailableMinCycleLife2(): ?int
    {
        return $this->percentProductAvailableMinCycleLife2;
    }

    public function setPercentProductAvailableMinCycleLife2(int $percentProductAvailableMinCycleLife2): self
    {
        $this->percentProductAvailableMinCycleLife2 = $percentProductAvailableMinCycleLife2;

        return $this;
    }

    public function getPercentProductAvailableMinCycleLife3(): ?int
    {
        return $this->percentProductAvailableMinCycleLife3;
    }

    public function setPercentProductAvailableMinCycleLife3(int $percentProductAvailableMinCycleLife3): self
    {
        $this->percentProductAvailableMinCycleLife3 = $percentProductAvailableMinCycleLife3;

        return $this;
    }

    public function getPercentProductAvailableMinCycleLife4(): ?int
    {
        return $this->percentProductAvailableMinCycleLife4;
    }

    public function setPercentProductAvailableMinCycleLife4(int $percentProductAvailableMinCycleLife4): self
    {
        $this->percentProductAvailableMinCycleLife4 = $percentProductAvailableMinCycleLife4;

        return $this;
    }

    public function getPercentProductAvailableMaxCycleLife1(): ?int
    {
        return $this->percentProductAvailableMaxCycleLife1;
    }

    public function setPercentProductAvailableMaxCycleLife1(int $percentProductAvailableMaxCycleLife1): self
    {
        $this->percentProductAvailableMaxCycleLife1 = $percentProductAvailableMaxCycleLife1;

        return $this;
    }

    public function getPercentProductAvailableMaxCycleLife2(): ?int
    {
        return $this->percentProductAvailableMaxCycleLife2;
    }

    public function setPercentProductAvailableMaxCycleLife2(int $percentProductAvailableMaxCycleLife2): self
    {
        $this->percentProductAvailableMaxCycleLife2 = $percentProductAvailableMaxCycleLife2;

        return $this;
    }

    public function getPercentProductAvailableMaxCycleLife3(): ?int
    {
        return $this->percentProductAvailableMaxCycleLife3;
    }

    public function setPercentProductAvailableMaxCycleLife3(int $percentProductAvailableMaxCycleLife3): self
    {
        $this->percentProductAvailableMaxCycleLife3 = $percentProductAvailableMaxCycleLife3;

        return $this;
    }

    public function getPercentProductAvailableMaxCycleLife4(): ?int
    {
        return $this->percentProductAvailableMaxCycleLife4;
    }

    public function setPercentProductAvailableMaxCycleLife4(int $percentProductAvailableMaxCycleLife4): self
    {
        $this->percentProductAvailableMaxCycleLife4 = $percentProductAvailableMaxCycleLife4;

        return $this;
    }

    public function getProductQualityMinCycleLife1(): ?int
    {
        return $this->productQualityMinCycleLife1;
    }

    public function setProductQualityMinCycleLife1(int $productQualityMinCycleLife1): self
    {
        $this->productQualityMinCycleLife1 = $productQualityMinCycleLife1;

        return $this;
    }

    public function getProductQualityMinCycleLife2(): ?int
    {
        return $this->productQualityMinCycleLife2;
    }

    public function setProductQualityMinCycleLife2(int $productQualityMinCycleLife2): self
    {
        $this->productQualityMinCycleLife2 = $productQualityMinCycleLife2;

        return $this;
    }

    public function getProductQualityMinCycleLife3(): ?int
    {
        return $this->productQualityMinCycleLife3;
    }

    public function setProductQualityMinCycleLife3(int $productQualityMinCycleLife3): self
    {
        $this->productQualityMinCycleLife3 = $productQualityMinCycleLife3;

        return $this;
    }

    public function getProductQualityMinCycleLife4(): ?int
    {
        return $this->productQualityMinCycleLife4;
    }

    public function setProductQualityMinCycleLife4(int $productQualityMinCycleLife4): self
    {
        $this->productQualityMinCycleLife4 = $productQualityMinCycleLife4;

        return $this;
    }

    public function getProductQualityMaxCycleLife1(): ?int
    {
        return $this->productQualityMaxCycleLife1;
    }

    public function setProductQualityMaxCycleLife1(int $productQualityMaxCycleLife1): self
    {
        $this->productQualityMaxCycleLife1 = $productQualityMaxCycleLife1;

        return $this;
    }

    public function getProductQualityMaxCycleLife2(): ?int
    {
        return $this->productQualityMaxCycleLife2;
    }

    public function setProductQualityMaxCycleLife2(int $productQualityMaxCycleLife2): self
    {
        $this->productQualityMaxCycleLife2 = $productQualityMaxCycleLife2;

        return $this;
    }

    public function getProductQualityMaxCycleLife3(): ?int
    {
        return $this->productQualityMaxCycleLife3;
    }

    public function setProductQualityMaxCycleLife3(int $productQualityMaxCycleLife3): self
    {
        $this->productQualityMaxCycleLife3 = $productQualityMaxCycleLife3;

        return $this;
    }

    public function getProductQualityMaxCycleLife4(): ?int
    {
        return $this->productQualityMaxCycleLife4;
    }

    public function setProductQualityMaxCycleLife4(int $productQualityMaxCycleLife4): self
    {
        $this->productQualityMaxCycleLife4 = $productQualityMaxCycleLife4;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGame($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getGame() === $this) {
                $user->setGame(null);
            }
        }

        return $this;
    }
}
