<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesManProfessionalRepository")
 */
class SalesManProfessional extends SalesMan
{

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityProfessional;

    public function getSalesActivityProfessional(): ?int
    {
        return $this->salesActivityProfessional;
    }

    public function setSalesActivityProfessional(int $salesActivityProfessional): self
    {
        $this->salesActivityProfessional = $salesActivityProfessional;

        return $this;
    }

    public function __toString()
    {
        return 'Salesman pro';
    }
}
