<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $gameNum = null;

    #[ORM\Column(length: 150)]
    private ?string $gameName = null;

    #[ORM\Column]
    private ?int $numberOfPlayer = null;

    #[ORM\Column(length: 150)]
    private ?string $category = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Availability::class)]
    private Collection $id_availability;

    #[ORM\OneToMany(mappedBy: 'id_game', targetEntity: GameUser::class, orphanRemoval: true)]
    private Collection $gameUsers;

    public function __construct()
    {
        $this->id_availability = new ArrayCollection();
        $this->gameUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameNum(): ?string
    {
        return $this->gameNum;
    }

    public function setGameNum(string $gameNum): self
    {
        $this->gameNum = $gameNum;

        return $this;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getNumberOfPlayer(): ?int
    {
        return $this->numberOfPlayer;
    }

    public function setNumberOfPlayer(int $numberOfPlayer): self
    {
        $this->numberOfPlayer = $numberOfPlayer;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, availability>
     */
    public function getIdAvailability(): Collection
    {
        return $this->id_availability;
    }

    public function addIdAvailability(availability $idAvailability): self
    {
        if (!$this->id_availability->contains($idAvailability)) {
            $this->id_availability->add($idAvailability);
            $idAvailability->setGame($this);
        }

        return $this;
    }

    public function removeIdAvailability(availability $idAvailability): self
    {
        if ($this->id_availability->removeElement($idAvailability)) {
            // set the owning side to null (unless already changed)
            if ($idAvailability->getGame() === $this) {
                $idAvailability->setGame(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getGameName();
    }

    /**
     * @return Collection<int, GameUser>
     */
    public function getGameUsers(): Collection
    {
        return $this->gameUsers;
    }

    public function addGameUser(GameUser $gameUser): self
    {
        if (!$this->gameUsers->contains($gameUser)) {
            $this->gameUsers->add($gameUser);
            $gameUser->setIdGame($this);
        }

        return $this;
    }

    public function removeGameUser(GameUser $gameUser): self
    {
        if ($this->gameUsers->removeElement($gameUser)) {
            // set the owning side to null (unless already changed)
            if ($gameUser->getIdGame() === $this) {
                $gameUser->setIdGame(null);
            }
        }

        return $this;
    }
}
