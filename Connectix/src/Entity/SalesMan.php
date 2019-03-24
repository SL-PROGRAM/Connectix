<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesManRepository")
 */
abstract class SalesMan extends HumanResource
{
       /**
     * @ORM\Column(type="integer")
     */
    private $commission;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivity;

    public function getCommission(): ?int
    {
        return $this->commission;
    }

    public function setCommission(int $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function getSalesActivity(): ?int
    {
        return $this->salesActivity;
    }

    public function setSalesActivity(int $salesActivity): self
    {
        $this->salesActivity = $salesActivity;

        return $this;
    }
}
