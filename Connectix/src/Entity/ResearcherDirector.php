<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResearcherDirectorRepository")
 */
class ResearcherDirector extends Researcher
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
    private $administrationActivity;

    public function getId(): ?int
    {
        return $this->id;
    }

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