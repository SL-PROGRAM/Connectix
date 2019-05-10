<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkManRepository")
 * Class WorkMan
 * @package App\Entity
 */
class WorkMan extends Production
{
    public function __toString()
    {
        return 'WorkMan';
    }
}
