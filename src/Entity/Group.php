<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $groupNum = null;

    #[ORM\Column(length: 50)]
    private ?string $groupName = null;

    #[ORM\OneToOne(mappedBy: 'id_group', cascade: ['persist', 'remove'])]
    private ?UserGroup $userGroup = null;

    #[ORM\OneToMany(mappedBy: 'id_group', targetEntity: GroupGame::class, orphanRemoval: true)]
    private Collection $groupGames;

    public function __construct()
    {
        $this->groupGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumGroup(): ?string
    {
        return $this->groupNum;
    }

    public function setNumGroup(string $groupNum): self
    {
        $this->groupNum = $groupNum;

        return $this;
    }

    public function getNameGroup(): ?string
    {
        return $this->groupName;
    }

    public function setNameGroup(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getUserGroup(): ?UserGroup
    {
        return $this->userGroup;
    }

    public function setUserGroup(UserGroup $userGroup): self
    {
        // set the owning side of the relation if necessary
        if ($userGroup->getIdGroup() !== $this) {
            $userGroup->setIdGroup($this);
        }

        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * @return Collection<int, GroupGame>
     */
    public function getGroupGames(): Collection
    {
        return $this->groupGames;
    }

    public function addGroupGame(GroupGame $groupGame): self
    {
        if (!$this->groupGames->contains($groupGame)) {
            $this->groupGames->add($groupGame);
            $groupGame->setIdGroup($this);
        }

        return $this;
    }

    public function removeGroupGame(GroupGame $groupGame): self
    {
        if ($this->groupGames->removeElement($groupGame)) {
            // set the owning side to null (unless already changed)
            if ($groupGame->getIdGroup() === $this) {
                $groupGame->setIdGroup(null);
            }
        }

        return $this;
    }
}
