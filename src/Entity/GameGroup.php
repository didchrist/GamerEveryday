<?php

namespace App\Entity;

use App\Repository\GameGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameGroupRepository::class)]
class GameGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Game::class)]
    private Collection $id_Game;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'gameGroups')]
    private Collection $id_Group;

    public function __construct()
    {
        $this->id_Game = new ArrayCollection();
        $this->id_Group = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getIdGame(): Collection
    {
        return $this->id_Game;
    }

    public function addIdGame(Game $idGame): self
    {
        if (!$this->id_Game->contains($idGame)) {
            $this->id_Game->add($idGame);
        }

        return $this;
    }

    public function removeIdGame(Game $idGame): self
    {
        $this->id_Game->removeElement($idGame);

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getIdGroup(): Collection
    {
        return $this->id_Group;
    }

    public function addIdGroup(Group $idGroup): self
    {
        if (!$this->id_Group->contains($idGroup)) {
            $this->id_Group->add($idGroup);
        }

        return $this;
    }

    public function removeIdGroup(Group $idGroup): self
    {
        $this->id_Group->removeElement($idGroup);

        return $this;
    }
}
