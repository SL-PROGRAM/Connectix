<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionCadreRepository")
 * Class ProductionCadre
 * @package App\Entity
 */
abstract class ProductionCadre extends Production
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
}
