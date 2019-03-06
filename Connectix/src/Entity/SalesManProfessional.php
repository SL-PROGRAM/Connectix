<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesManProfessionalRepository")
 */
class SalesManProfessional extends SalesMan
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
    private $salesActivityProfessional;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalesActivityProfessional(): ?int
    {
        return $this->salesActivityProfessional;
    }

    public function setSalesActivityProfessional(int $salesActivityProfessional): self
    {
        $this->salesActivityProfessional = $salesActivityProfessional;

        return $this;
    }
}
