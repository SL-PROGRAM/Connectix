<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PublicityOrderRepository")
 */
class PublicityOrder
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
    private $turn;

    /**
     * @ORM\Column(type="integer")
     */
    private $publicityPrice;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\socity", inversedBy="publicityOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $socity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getPublicityPrice(): ?int
    {
        return $this->publicityPrice;
    }

    public function setPublicityPrice(int $publicityPrice): self
    {
        $this->publicityPrice = $publicityPrice;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getSocity(): ?socity
    {
        return $this->socity;
    }

    public function setSocity(?socity $socity): self
    {
        $this->socity = $socity;

        return $this;
    }
}
