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

    #[ORM\ManyToMany(targetEntity: game::class)]
    private Collection $id_game;

    public function __construct()
    {
        $this->id_game = new ArrayCollection();
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
    public function getIdGame(): Collection
    {
        return $this->id_game;
    }

    public function addIdGame(game $idGame): self
    {
        if (!$this->id_game->contains($idGame)) {
            $this->id_game->add($idGame);
        }

        return $this;
    }

    public function removeIdGame(game $idGame): self
    {
        $this->id_game->removeElement($idGame);

        return $this;
    }
}
