<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkManRepository")
 */
class WorkMan extends Production
{
    public function __toString()
    {
        return 'WorkMan';
    }
}
