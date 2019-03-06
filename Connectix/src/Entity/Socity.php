<?php

namespace App\Entity;

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
    private $moneyStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMinPublicicyImpact;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMaxPublicityImpact;

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
    public function getMoneyStart(): ?int
    {
        return $this->moneyStart;
    }

    /**
     * @param int $moneyStart
     * @return Socity
     */
    public function setMoneyStart(int $moneyStart): self
    {
        $this->moneyStart = $moneyStart;

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
}
