<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoanRepository")
 */
class Loan
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
    private $borrowAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $bankInterest;

    /**
     * @ORM\Column(type="integer")
     */
    private $monthlyDueDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanDuration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="Loans")
     */
    private $socity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowAmount(): ?int
    {
        return $this->borrowAmount;
    }

    public function setBorrowAmount(int $borrowAmount): self
    {
        $this->borrowAmount = $borrowAmount;

        return $this;
    }

    public function getBankInterest(): ?int
    {
        return $this->bankInterest;
    }

    public function setBankInterest(int $bankInterest): self
    {
        $this->bankInterest = $bankInterest;

        return $this;
    }

    public function getMonthlyDueDate(): ?int
    {
        return $this->monthlyDueDate;
    }

    public function setMonthlyDueDate(int $monthlyDueDate): self
    {
        $this->monthlyDueDate = $monthlyDueDate;

        return $this;
    }

    public function getLoanDuration(): ?int
    {
        return $this->loanDuration;
    }

    public function setLoanDuration(int $loanDuration): self
    {
        $this->loanDuration = $loanDuration;

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
}