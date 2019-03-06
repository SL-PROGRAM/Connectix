<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReseacherRepository")
 */
class Researcher extends HumanRessource
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
    private $researchActivity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReseachActivity(): ?int
    {
        return $this->researchActivity;
    }

    public function setReseachActivity(int $researchActivity): self
    {
        $this->researchActivity = $researchActivity;

        return $this;
    }
}
