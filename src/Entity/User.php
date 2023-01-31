<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(
    fields: ['email'],
    message: 'Adresse email deja utilisé'
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 100)]
    #[Assert\Email(message: 'L\'email {{ value }} n\'est pas un email valide')]
    private ?string $email = null;

    #[ORM\Column(length: 150)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Availability::class)]
    private Collection $availabilities;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: GameUser::class, orphanRemoval: true)]
    private Collection $gameUsers;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->gameUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function eraseCredentials()
    {
    }
    public function getSalt(): ?string
    {
        return null;
    }
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setIdUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getIdUser() === $this) {
                $message->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Availability>
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities->add($availability);
            $availability->setIdUser($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getIdUser() === $this) {
                $availability->setIdUser(null);
            }
        }

        return $this;
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
            $gameUser->setIdUser($this);
        }

        return $this;
    }

    public function removeGameUser(GameUser $gameUser): self
    {
        if ($this->gameUsers->removeElement($gameUser)) {
            // set the owning side to null (unless already changed)
            if ($gameUser->getIdUser() === $this) {
                $gameUser->setIdUser(null);
            }
        }

        return $this;
    }
}
