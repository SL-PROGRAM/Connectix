<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionDirectorRepository")
 */
class ProductionDirector extends ProductionCadre
{
    public function __toString()
    {
        return 'production Director';
    }
}
