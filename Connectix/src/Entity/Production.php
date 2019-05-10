<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionRepository")
 * Class Production
 * @package App\Entity
 */
abstract class Production extends HumanResource
{

    /**
     * @ORM\Column(type="integer")
     */
    private $productionActivity;

    public function getProductionActivity(): ?int
    {
        return $this->productionActivity;
    }

    public function setProductionActivity(int $productionActivity): self
    {
        $this->productionActivity = $productionActivity;

        return $this;
    }
}
