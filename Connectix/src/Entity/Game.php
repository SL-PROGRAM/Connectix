<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $tva;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxturn;

    /**
     * @ORM\Column(type="integer")
     */
    private $turn;

    /**
     * @ORM\Column(type="integer")
     */
    private $socityNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $smic;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Game
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTva(): ?int
    {
        return $this->tva;
    }

    /**
     * @param int $tva
     * @return Game
     */
    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxturn(): ?int
    {
        return $this->maxturn;
    }

    /**
     * @param int $maxturn
     * @return Game
     */
    public function setMaxturn(int $maxturn): self
    {
        $this->maxturn = $maxturn;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTurn(): ?int
    {
        return $this->turn;
    }

    /**
     * @param int $turn
     * @return Game
     */
    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSocityNumber(): ?int
    {
        return $this->socityNumber;
    }

    /**
     * @param int $socityNumber
     * @return Game
     */
    public function setSocityNumber(int $socityNumber): self
    {
        $this->socityNumber = $socityNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSmic(): ?int
    {
        return $this->smic;
    }

    /**
     * @param int $smic
     * @return Game
     */
    public function setSmic(int $smic): self
    {
        $this->smic = $smic;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    /**
     * @param \DateTimeInterface $creatAt
     * @return Game
     */
    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }
}
