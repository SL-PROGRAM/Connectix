<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocityRepository")
 */
class Socity
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
    private $priceMinPublicicyImpact;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMaxPublicityImpact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="socities")
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="socity", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HumanResource", mappedBy="socity", orphanRemoval=true)
     */
    private $humanRessourcies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductionUnit", mappedBy="socity")
     */
    private $ProductionUnits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Loan", mappedBy="socity")
     */
    private $Loans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BalanceSheet", mappedBy="socity")
     */
    private $balanceSheets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PurchaseOrder", mappedBy="socity")
     */
    private $purchaseOrders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SalesOrder", mappedBy="socity")
     */
    private $salesOrders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReseachOrder", mappedBy="socity", orphanRemoval=true)
     */
    private $reseachOrders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PublicityOrder", mappedBy="socity", orphanRemoval=true)
     */
    private $publicityOrders;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->humanRessourcies = new ArrayCollection();
        $this->ProductionUnits = new ArrayCollection();
        $this->Loans = new ArrayCollection();
        $this->balanceSheets = new ArrayCollection();
        $this->purchaseOrders = new ArrayCollection();
        $this->salesOrders = new ArrayCollection();
        $this->reseachOrders = new ArrayCollection();
        $this->publicityOrders = new ArrayCollection();
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
     * @return Socity
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getPriceMinPublicicyImpact(): ?int
    {
        return $this->priceMinPublicicyImpact;
    }

    /**
     * @param int $priceMinPublicicyImpact
     * @return Socity
     */
    public function setPriceMinPublicicyImpact(int $priceMinPublicicyImpact): self
    {
        $this->priceMinPublicicyImpact = $priceMinPublicicyImpact;

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
     * @return Socity
     */
    public function setPriceMaxPublicityImpact(int $priceMaxPublicityImpact): self
    {
        $this->priceMaxPublicityImpact = $priceMaxPublicityImpact;

        return $this;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @param Game|null $game
     * @return Socity
     */
    public function setGame(?Game $game): self
    {
        $this->game = $game;

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
            $user->setSocity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getSocity() === $this) {
                $user->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HumanResource[]
     */
    public function getHumanRessourcies(): Collection
    {
        return $this->humanRessourcies;
    }

    public function addHumanRessourcy(HumanResource $humanRessourcy): self
    {
        if (!$this->humanRessourcies->contains($humanRessourcy)) {
            $this->humanRessourcies[] = $humanRessourcy;
            $humanRessourcy->setSocity($this);
        }

        return $this;
    }

    public function removeHumanRessourcy(HumanResource $humanRessourcy): self
    {
        if ($this->humanRessourcies->contains($humanRessourcy)) {
            $this->humanRessourcies->removeElement($humanRessourcy);
            // set the owning side to null (unless already changed)
            if ($humanRessourcy->getSocity() === $this) {
                $humanRessourcy->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductionUnit[]
     */
    public function getProductionUnits(): Collection
    {
        return $this->ProductionUnits;
    }

    public function addProductionUnit(ProductionUnit $productionUnit): self
    {
        if (!$this->ProductionUnits->contains($productionUnit)) {
            $this->ProductionUnits[] = $productionUnit;
            $productionUnit->setSocity($this);
        }

        return $this;
    }

    public function removeProductionUnit(ProductionUnit $productionUnit): self
    {
        if ($this->ProductionUnits->contains($productionUnit)) {
            $this->ProductionUnits->removeElement($productionUnit);
            // set the owning side to null (unless already changed)
            if ($productionUnit->getSocity() === $this) {
                $productionUnit->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Loan[]
     */
    public function getLoans(): Collection
    {
        return $this->Loans;
    }

    public function addLoan(Loan $loan): self
    {
        if (!$this->Loans->contains($loan)) {
            $this->Loans[] = $loan;
            $loan->setSocity($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): self
    {
        if ($this->Loans->contains($loan)) {
            $this->Loans->removeElement($loan);
            // set the owning side to null (unless already changed)
            if ($loan->getSocity() === $this) {
                $loan->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BalanceSheet[]
     */
    public function getBalanceSheets(): Collection
    {
        return $this->balanceSheets;
    }

    public function addBalanceSheet(BalanceSheet $balanceSheet): self
    {
        if (!$this->balanceSheets->contains($balanceSheet)) {
            $this->balanceSheets[] = $balanceSheet;
            $balanceSheet->setSocity($this);
        }

        return $this;
    }

    public function removeBalanceSheet(BalanceSheet $balanceSheet): self
    {
        if ($this->balanceSheets->contains($balanceSheet)) {
            $this->balanceSheets->removeElement($balanceSheet);
            // set the owning side to null (unless already changed)
            if ($balanceSheet->getSocity() === $this) {
                $balanceSheet->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PurchaseOrder[]
     */
    public function getPurchaseOrders(): Collection
    {
        return $this->purchaseOrders;
    }

    public function addPurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if (!$this->purchaseOrders->contains($purchaseOrder)) {
            $this->purchaseOrders[] = $purchaseOrder;
            $purchaseOrder->setSocity($this);
        }

        return $this;
    }

    public function removePurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if ($this->purchaseOrders->contains($purchaseOrder)) {
            $this->purchaseOrders->removeElement($purchaseOrder);
            // set the owning side to null (unless already changed)
            if ($purchaseOrder->getSocity() === $this) {
                $purchaseOrder->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SalesOrder[]
     */
    public function getSalesOrders(): Collection
    {
        return $this->salesOrders;
    }

    public function addSalesOrder(SalesOrder $salesOrder): self
    {
        if (!$this->salesOrders->contains($salesOrder)) {
            $this->salesOrders[] = $salesOrder;
            $salesOrder->setSocity($this);
        }

        return $this;
    }

    public function removeSalesOrder(SalesOrder $salesOrder): self
    {
        if ($this->salesOrders->contains($salesOrder)) {
            $this->salesOrders->removeElement($salesOrder);
            // set the owning side to null (unless already changed)
            if ($salesOrder->getSocity() === $this) {
                $salesOrder->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReseachOrder[]
     */
    public function getReseachOrders(): Collection
    {
        return $this->reseachOrders;
    }

    public function addReseachOrder(ReseachOrder $reseachOrder): self
    {
        if (!$this->reseachOrders->contains($reseachOrder)) {
            $this->reseachOrders[] = $reseachOrder;
            $reseachOrder->setSocity($this);
        }

        return $this;
    }

    public function removeReseachOrder(ReseachOrder $reseachOrder): self
    {
        if ($this->reseachOrders->contains($reseachOrder)) {
            $this->reseachOrders->removeElement($reseachOrder);
            // set the owning side to null (unless already changed)
            if ($reseachOrder->getSocity() === $this) {
                $reseachOrder->setSocity(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|PublicityOrder[]
     */
    public function getPublicityOrders(): Collection
    {
        return $this->publicityOrders;
    }

    public function addPublicityOrder(PublicityOrder $publicityOrder): self
    {
        if (!$this->publicityOrders->contains($publicityOrder)) {
            $this->publicityOrders[] = $publicityOrder;
            $publicityOrder->setSocity($this);
        }

        return $this;
    }

    public function removePublicityOrder(PublicityOrder $publicityOrder): self
    {
        if ($this->publicityOrders->contains($publicityOrder)) {
            $this->publicityOrders->removeElement($publicityOrder);
            // set the owning side to null (unless already changed)
            if ($publicityOrder->getSocity() === $this) {
                $publicityOrder->setSocity(null);
            }
        }

        return $this;
    }
}
