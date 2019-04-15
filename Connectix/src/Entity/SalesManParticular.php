<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesManParticularRepository")
 */
class SalesManParticular extends SalesMan
{

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityParticular;

    public function getSalesActivityParticular(): ?int
    {
        return $this->salesActivityParticular;
    }

    public function setSalesActivityParticular(int $salesActivityParticular): self
    {
        $this->salesActivityParticular = $salesActivityParticular;

        return $this;
    }

    public function __toString()
    {
        return 'Salesman particular';
    }
}
