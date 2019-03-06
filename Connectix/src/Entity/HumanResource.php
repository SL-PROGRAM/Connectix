<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HumanRessourceRepository")
 */
abstract class HumanResource
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
    private $salary;

    /**
     * @ORM\Column(type="integer")
     */
    private $formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $exprience;

    /**
     * @ORM\Column(type="integer")
     */
    private $productivity;

    /**
     * @ORM\Column(type="integer")
     */
    private $administrationActivityCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $coeficientSalary;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="humanRessourcies")
     */
    private $socity;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getFormation(): ?int
    {
        return $this->formation;
    }

    public function setFormation(int $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getExprience(): ?int
    {
        return $this->exprience;
    }

    public function setExprience(int $exprience): self
    {
        $this->exprience = $exprience;

        return $this;
    }

    public function getProductivity(): ?int
    {
        return $this->productivity;
    }

    public function setProductivity(int $productivity): self
    {
        $this->productivity = $productivity;

        return $this;
    }

    public function getAdministrationActivityCost(): ?int
    {
        return $this->administrationActivityCost;
    }

    public function setAdministrationActivityCost(int $administrationActivityCost): self
    {
        $this->administrationActivityCost = $administrationActivityCost;

        return $this;
    }

    public function getSocity(): ?Socity
    {
        return $this->socity;
    }

    public function setSocity(?Socity $socity): self
    {
        $this->socity = $socity;

        return $this;
    }

    public function getCoeficientSalary(): ?int
    {
        return $this->coeficientSalary;
    }

    public function setCoeficientSalary(int $coeficientSalary): self
    {
        $this->coeficientSalary = $coeficientSalary;

        return $this;
    }
}
