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
    private $tva = 20;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxturn = 20;

    /**
     * @ORM\Column(type="integer")
     */
    private $turn = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityNumber = 5;

    /**
     * @ORM\Column(type="float")
     */
    private $smic = 1521.25 ;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="game", orphanRemoval=true, cascade={"remove"})
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Socity", mappedBy="game", orphanRemoval=true,cascade={"persist", "remove"})
     */
    private $socities;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMin = 1000;


    /**
     * @ORM\Column(type="integer")
     */
    private $salesPriceMax = 2000;


    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMin = 10000;


    /**
     * @ORM\Column(type="integer")
     */
    private $productNumberMax  = 20000;


    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife1 = 25;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife2 = 45;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife3 = 65;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMinCycleLife4 = 80;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife1 = 45;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife2 = 65;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife3 = 80;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentProductAvailableMaxCycleLife4 = 90;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife1 = 96;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife2 = 97;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife3 = 97;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMinCycleLife4 = 97;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife1 = 99;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife2 = 100;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife3 = 99;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQualityMaxCycleLife4 = 98;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="game", cascade={"persist"})
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $taxTurnover = 2;

    /**
     * @ORM\Column(type="integer")
     */
    private $employerContributions = 40;

    /**
     * @ORM\Column(type="integer")
     */
    private $payTax = 3;

    /**
     * @ORM\Column(type="integer")
     */
    private $variableExternalCharges = 8;

    /**
     * @ORM\Column(type="integer")
     */
    private $rowMaterialCost = 10;

    /**
     * @ORM\Column(type="integer")
     */
    private $rawMaterialMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $rawMaterialMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $manPowerMin = 2;

    /**
     * @ORM\Column(type="integer")
     */
    private $manPowerMax = 10;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionTimeMin = 2;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionTimeMax = 10 ;

    /**
     * @ORM\Column(type="integer")
     */
    private $taxRate = 28;

    /**
     * @ORM\Column(type="integer")
     */
    private $employeeParticipation = 5;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityStartShareCapital = 400000;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityStartLoanAmount = 400000;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityStartLoanDuration = 5;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityStartLoanInterestRate = 2;

    /**
     * @ORM\Column(type="integer")
     */
    private $annualHoursWork = 1607;

    /**
     * @ORM\Column(type="integer")
     */
    private $factoryCreationCost = 560000;

    /**
     * @ORM\Column(type="integer")
     */
    private $factoryMaintenanceCost = 10000;

    /**
     * @ORM\Column(type="integer")
     */
    private $factoryAdministrationCost = 100;

    /**
     * @ORM\Column(type="integer")
     */
    private $factoryAmortizationTurn = 15;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionLignCreationCost = 250000;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionLignMaintenanceCost = 1500;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionLignAdministrationCost = 50;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionLignAmortizationTurn = 5;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionLignAnnualProductTime = 15000;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionLignTotalLifeProductTime = 180000;

    /**
     * @ORM\Column(type="integer")
     */
    private $groundCost = 100000;

    /**
     * @ORM\Column(type="integer")
     */
    private $salaryContributions = 22;

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

    public function getSalesPriceMin(): ?int
    {
        return $this->salesPriceMin;
    }

    public function setSalesPrice(int $salesPriceMin): self
    {
        $this->salesPriceMin = $salesPriceMin;

        return $this;
    }

    public function getSalesPriceMax(): ?int
    {
        return $this->salesPriceMax;
    }

    public function setSalesPriceMax(int $salesPriceMax): self
    {
        $this->salesPriceMax = $salesPriceMax;

        return $this;
    }


    public function getProductNumberMin(): ?int
    {
        return $this->productNumberMin;
    }

    public function setProductNumberMin(int $productNumberMin): self
    {
        $this->productNumberMin = $productNumberMin;

        return $this;
    }


    public function getProductNumberMax(): ?int
    {
        return $this->productNumberMax;
    }

    public function setProductNumberMax(int $productNumberMax): self
    {
        $this->productNumberMax = $productNumberMax;

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

    public function getTaxTurnover(): ?int
    {
        return $this->taxTurnover;
    }

    public function setTaxTurnover(int $taxTurnover): self
    {
        $this->taxTurnover = $taxTurnover;

        return $this;
    }

    public function getEmployerContributions(): ?int
    {
        return $this->employerContributions;
    }

    public function setEmployerContributions(int $employerContributions): self
    {
        $this->employerContributions = $employerContributions;

        return $this;
    }

    public function getPayTax(): ?int
    {
        return $this->payTax;
    }

    public function setPayTax(int $payTax): self
    {
        $this->payTax = $payTax;

        return $this;
    }

    public function getVariableExternalCharges(): ?int
    {
        return $this->variableExternalCharges;
    }

    public function setVariableExternalCharges(int $variableExternalCharges): self
    {
        $this->variableExternalCharges = $variableExternalCharges;

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

    public function getRawMaterialMin(): ?int
    {
        return $this->rawMaterialMin;
    }

    public function setRawMaterialMin(int $rawMaterialMin): self
    {
        $this->rawMaterialMin = $rawMaterialMin;

        return $this;
    }

    public function getRawMaterialMax(): ?int
    {
        return $this->rawMaterialMax;
    }

    public function setRawMaterialMax(int $rawMaterialMax): self
    {
        $this->rawMaterialMax = $rawMaterialMax;

        return $this;
    }

    public function getManPowerMin(): ?int
    {
        return $this->manPowerMin;
    }

    public function setManPowerMin(int $manPowerMin): self
    {
        $this->manPowerMin = $manPowerMin;

        return $this;
    }

    public function getManPowerMax(): ?int
    {
        return $this->manPowerMax;
    }

    public function setManPowerMax(int $manPowerMax): self
    {
        $this->manPowerMax = $manPowerMax;

        return $this;
    }

    public function getProductionTimeMin(): ?int
    {
        return $this->productionTimeMin;
    }

    public function setProductionTimeMin(int $productionTimeMin): self
    {
        $this->productionTimeMin = $productionTimeMin;

        return $this;
    }

    public function getProductionTimeMax(): ?int
    {
        return $this->productionTimeMax;
    }

    public function setProductionTimeMax(int $productionTimeMax): self
    {
        $this->productionTimeMax = $productionTimeMax;

        return $this;
    }

    public function getTaxRate(): ?int
    {
        return $this->taxRate;
    }

    public function setTaxRate(int $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getEmployeeParticipation(): ?int
    {
        return $this->employeeParticipation;
    }

    public function setEmployeeParticipation(int $employeeParticipation): self
    {
        $this->employeeParticipation = $employeeParticipation;

        return $this;
    }

    public function getSocityStartShareCapital(): ?int
    {
        return $this->socityStartShareCapital;
    }

    public function setSocityStartShareCapital(int $socityStartShareCapital): self
    {
        $this->socityStartShareCapital = $socityStartShareCapital;

        return $this;
    }

    public function getSocityStartLoanAmount(): ?int
    {
        return $this->socityStartLoanAmount;
    }

    public function setSocityStartLoanAmount(int $socityStartLoanAmount): self
    {
        $this->socityStartLoanAmount = $socityStartLoanAmount;

        return $this;
    }

    public function getSocityStartLoanDuration(): ?int
    {
        return $this->socityStartLoanDuration;
    }

    public function setSocityStartLoanDuration(int $socityStartLoanDuration): self
    {
        $this->socityStartLoanDuration = $socityStartLoanDuration;

        return $this;
    }

    public function getSocityStartLoanInterestRate(): ?int
    {
        return $this->socityStartLoanInterestRate;
    }

    public function setSocityStartLoanInterestRate(int $socityStartLoanInterestRate): self
    {
        $this->socityStartLoanInterestRate = $socityStartLoanInterestRate;

        return $this;
    }

    public function getAnnualHoursWork(): ?int
    {
        return $this->annualHoursWork;
    }

    public function setAnnualHoursWork(int $annualHoursWork): self
    {
        $this->annualHoursWork = $annualHoursWork;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getFactoryCreationCost(): ?int
    {
        return $this->factoryCreationCost;
    }

    public function setFactoryCreationCost(int $factoryCreationCost): self
    {
        $this->factoryCreationCost = $factoryCreationCost;

        return $this;
    }

    public function getFactoryMaintenanceCost(): ?int
    {
        return $this->factoryMaintenanceCost;
    }

    public function setFactoryMaintenanceCost(int $factoryMaintenanceCost): self
    {
        $this->factoryMaintenanceCost = $factoryMaintenanceCost;

        return $this;
    }

    public function getFactoryAdministrationCost(): ?int
    {
        return $this->factoryAdministrationCost;
    }

    public function setFactoryAdministrationCost(int $factoryAdministrationCost): self
    {
        $this->factoryAdministrationCost = $factoryAdministrationCost;

        return $this;
    }

    public function getFactoryAmortizationTurn(): ?int
    {
        return $this->factoryAmortizationTurn;
    }

    public function setFactoryAmortizationTurn(int $factoryAmortizationTurn): self
    {
        $this->factoryAmortizationTurn = $factoryAmortizationTurn;

        return $this;
    }

    public function getProductionLignCreationCost(): ?int
    {
        return $this->productionLignCreationCost;
    }

    public function setProductionLignCreationCost(int $productionLignCreationCost): self
    {
        $this->productionLignCreationCost = $productionLignCreationCost;

        return $this;
    }

    public function getProductionLignMaintenanceCost(): ?int
    {
        return $this->productionLignMaintenanceCost;
    }

    public function setProductionLignMaintenanceCost(int $productionLignMaintenanceCost): self
    {
        $this->productionLignMaintenanceCost = $productionLignMaintenanceCost;

        return $this;
    }

    public function getProductionLignAdministrationCost(): ?int
    {
        return $this->productionLignAdministrationCost;
    }

    public function setProductionLignAdministrationCost(int $productionLignAdministrationCost): self
    {
        $this->productionLignAdministrationCost = $productionLignAdministrationCost;

        return $this;
    }

    public function getProductionLignAmortizationTurn(): ?int
    {
        return $this->productionLignAmortizationTurn;
    }

    public function setProductionLignAmortizationTurn(int $productionLignAmortizationTurn): self
    {
        $this->productionLignAmortizationTurn = $productionLignAmortizationTurn;

        return $this;
    }

    public function getProductionLignAnnualProductTime(): ?int
    {
        return $this->productionLignAnnualProductTime;
    }

    public function setProductionLignAnnualProductTime(int $productionLignAnnualProductTime): self
    {
        $this->productionLignAnnualProductTime = $productionLignAnnualProductTime;

        return $this;
    }

    public function getProductionLignTotalLifeProductTime(): ?int
    {
        return $this->productionLignTotalLifeProductTime;
    }

    public function setProductionLignTotalLifeProductTime(int $productionLignTotalLifeProductTime): self
    {
        $this->productionLignTotalLifeProductTime = $productionLignTotalLifeProductTime;

        return $this;
    }

    public function getGroundCost(): ?int
    {
        return $this->groundCost;
    }

    public function setGroundCost(int $groundCost): self
    {
        $this->groundCost = $groundCost;

        return $this;
    }

    public function getSalaryContributions(): ?int
    {
        return $this->salaryContributions;
    }

    public function setSalaryContributions(int $salaryContributions): self
    {
        $this->salaryContributions = $salaryContributions;

        return $this;
    }
}
