<?php

namespace App\Entity;

use App\Repository\UserGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
class UserGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $role = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'userGroups')]
    private Collection $id_User;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'userGroups')]
    private Collection $id_Group;

    public function __construct()
    {
        $this->id_User = new ArrayCollection();
        $this->id_Group = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdUser(): Collection
    {
        return $this->id_User;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->id_User->contains($idUser)) {
            $this->id_User->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        $this->id_User->removeElement($idUser);

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
