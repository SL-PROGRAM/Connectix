<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnicianRepository")
 * Class Technician
 * @package App\Entity
 */
class Technician extends ProductionCadre
{
    public function __toString()
    {
        return 'technician';
    }
}
