<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Administration
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AdministrationRepository")
 */
class Administration extends HumanResource
{


    /**
     * @ORM\Column(type="integer")
     */
    private $administationActivity;


    /**
     * @return int|null
     */
    public function getAdministationActivity(): ?int
    {
        return $this->administationActivity;
    }

    /**
     * @param int $administationActivity
     * @return Administration
     */
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
