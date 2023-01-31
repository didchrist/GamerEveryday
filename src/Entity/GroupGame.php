<?php

namespace App\Entity;

use App\Repository\GroupGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupGameRepository::class)]
class GroupGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'groupGames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?group $id_group = null;

    #[ORM\ManyToMany(targetEntity: game::class, inversedBy: 'groupGames')]
    private Collection $game_id;

    public function __construct()
    {
        $this->game_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGroup(): ?group
    {
        return $this->id_group;
    }

    public function setIdGroup(?group $id_group): self
    {
        $this->id_group = $id_group;

        return $this;
    }
    
    /**
     * @return Collection<int, game>
     */
    public function getGameId(): Collection
    {
        return $this->game_id;
    }

    public function addGameId(game $gameId): self
    {
        if (!$this->game_id->contains($gameId)) {
            $this->game_id->add($gameId);
        }

        return $this;
    }

    public function removeGameId(game $gameId): self
    {
        $this->game_id->removeElement($gameId);

        return $this;
    }
}
