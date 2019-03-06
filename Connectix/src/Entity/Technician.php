<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnicianRepository")
 */
class Technician extends Production
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
    private $coeficientSalary;

    public function getId(): ?int
    {
        return $this->id;
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
