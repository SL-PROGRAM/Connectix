<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoanRepository")
 * Class Loan
 * @package App\Entity
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
     * @ORM\Column(type="float")
     */
    private $bankInterest;

    /**
     * @ORM\Column(type="float")
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

    /**
     * @ORM\Column(type="integer")
     */
    private $DelayLoanRepayment;

    /**
     * @ORM\Column(type="integer")
     */
    private $turn;

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

    public function getDelayLoanRepayment(): ?int
    {
        return $this->DelayLoanRepayment;
    }

    public function setDelayLoanRepayment(int $DelayLoanRepayment): self
    {
        $this->DelayLoanRepayment = $DelayLoanRepayment;

        return $this;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function __toString()
    {
        return 'Loan';
    }
}
