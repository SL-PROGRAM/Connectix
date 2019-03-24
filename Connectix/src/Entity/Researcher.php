<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResearcherRepository")
 */
class Researcher extends HumanResource
{

    /**
     * @ORM\Column(type="integer")
     */
    private $researchActivity;

    public function getResearchActivity(): ?int
    {
        return $this->researchActivity;
    }

    public function setResearchActivity(int $researchActivity): self
    {
        $this->researchActivity = $researchActivity;

        return $this;
    }
}
