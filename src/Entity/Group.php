<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $numGroup = null;

    #[ORM\Column(length: 255)]
    private ?string $nameGroup = null;

    #[ORM\Column]
    private ?bool $accesGroup = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionGroup = null;

    #[ORM\ManyToMany(targetEntity: UserGroup::class, mappedBy: 'id_Group')]
    private Collection $userGroups;

    #[ORM\ManyToMany(targetEntity: GameGroup::class, mappedBy: 'id_Group')]
    private Collection $gameGroups;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
        $this->gameGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumGroup(): ?string
    {
        return $this->numGroup;
    }

    public function setNumGroup(string $numGroup): self
    {
        $this->numGroup = $numGroup;

        return $this;
    }

    public function getNameGroup(): ?string
    {
        return $this->nameGroup;
    }

    public function setNameGroup(string $nameGroup): self
    {
        $this->nameGroup = $nameGroup;

        return $this;
    }

    public function isAccesGroup(): ?bool
    {
        return $this->accesGroup;
    }

    public function setAccesGroup(bool $accesGroup): self
    {
        $this->accesGroup = $accesGroup;

        return $this;
    }

    public function getDescriptionGroup(): ?string
    {
        return $this->descriptionGroup;
    }

    public function setDescriptionGroup(?string $descriptionGroup): self
    {
        $this->descriptionGroup = $descriptionGroup;

        return $this;
    }

    /**
     * @return Collection<int, UserGroup>
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(UserGroup $userGroup): self
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups->add($userGroup);
            $userGroup->addIdGroup($this);
        }

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup): self
    {
        if ($this->userGroups->removeElement($userGroup)) {
            $userGroup->removeIdGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, GameGroup>
     */
    public function getGameGroups(): Collection
    {
        return $this->gameGroups;
    }

    public function addGameGroup(GameGroup $gameGroup): self
    {
        if (!$this->gameGroups->contains($gameGroup)) {
            $this->gameGroups->add($gameGroup);
            $gameGroup->addIdGroup($this);
        }

        return $this;
    }

    public function removeGameGroup(GameGroup $gameGroup): self
    {
        if ($this->gameGroups->removeElement($gameGroup)) {
            $gameGroup->removeIdGroup($this);
        }

        return $this;
    }
}
