<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdministrationRepository")
 */
class Administration extends HumanResource
{


    /**
     * @ORM\Column(type="integer")
     */
    private $administationActivity;


    public function getAdministationActivity(): ?int
    {
        return $this->administationActivity;
    }

    public function setAdministationActivity(int $administationActivity): self
    {
        $this->administationActivity = $administationActivity;

        return $this;
    }

    public function __toString()
    {
        return 'administration';
    }
}
