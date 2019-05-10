<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesManDirectorRepository")
 * Class SalesManDirector
 * @package App\Entity
 */
class SalesManDirector extends SalesMan
{

    /**
     * @ORM\Column(type="integer")
     */
    private $administrationActivity;

    public function getAdministrationActivity(): ?int
    {
        return $this->administrationActivity;
    }

    public function setAdministrationActivity(int $administrationActivity): self
    {
        $this->administrationActivity = $administrationActivity;

        return $this;
    }

    public function __toString()
    {
        return 'Salesman director';
    }
}
