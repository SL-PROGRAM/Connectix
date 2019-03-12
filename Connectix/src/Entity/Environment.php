<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnvironmentRepository")
 */
class Environment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $inflation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInflation(): ?float
    {
        return $this->inflation;
    }

    public function setInflation(float $inflation): self
    {
        $this->inflation = $inflation;

        return $this;
    }
}
