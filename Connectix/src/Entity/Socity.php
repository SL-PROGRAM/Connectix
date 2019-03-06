<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocityRepository")
 */
class Socity
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
    private $moneyStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMinPublicicyImpact;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMaxPublicityImpact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="socities")
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="socity", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HumanRessource", mappedBy="socity", orphanRemoval=true)
     */
    private $humanRessourcies;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->humanRessourcies = new ArrayCollection();
    }

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
     * @return Socity
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMoneyStart(): ?int
    {
        return $this->moneyStart;
    }

    /**
     * @param int $moneyStart
     * @return Socity
     */
    public function setMoneyStart(int $moneyStart): self
    {
        $this->moneyStart = $moneyStart;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMinPublicicyImpact(): ?int
    {
        return $this->priceMinPublicicyImpact;
    }

    /**
     * @param int $priceMinPublicicyImpact
     * @return Socity
     */
    public function setPriceMinPublicicyImpact(int $priceMinPublicicyImpact): self
    {
        $this->priceMinPublicicyImpact = $priceMinPublicicyImpact;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMaxPublicityImpact(): ?int
    {
        return $this->priceMaxPublicityImpact;
    }

    /**
     * @param int $priceMaxPublicityImpact
     * @return Socity
     */
    public function setPriceMaxPublicityImpact(int $priceMaxPublicityImpact): self
    {
        $this->priceMaxPublicityImpact = $priceMaxPublicityImpact;

        return $this;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @param Game|null $game
     * @return Socity
     */
    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSocity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getSocity() === $this) {
                $user->setSocity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HumanRessource[]
     */
    public function getHumanRessourcies(): Collection
    {
        return $this->humanRessourcies;
    }

    public function addHumanRessourcy(HumanRessource $humanRessourcy): self
    {
        if (!$this->humanRessourcies->contains($humanRessourcy)) {
            $this->humanRessourcies[] = $humanRessourcy;
            $humanRessourcy->setSocity($this);
        }

        return $this;
    }

    public function removeHumanRessourcy(HumanRessource $humanRessourcy): self
    {
        if ($this->humanRessourcies->contains($humanRessourcy)) {
            $this->humanRessourcies->removeElement($humanRessourcy);
            // set the owning side to null (unless already changed)
            if ($humanRessourcy->getSocity() === $this) {
                $humanRessourcy->setSocity(null);
            }
        }

        return $this;
    }
}