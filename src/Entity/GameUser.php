<?php

namespace App\Entity;

use App\Repository\GameUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameUserRepository::class)]
class GameUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $showGame = null;

    #[ORM\ManyToOne(inversedBy: 'gameUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $id_game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isShowGame(): ?bool
    {
        return $this->showGame;
    }

    public function setShowGame(bool $showGame): self
    {
        $this->showGame = $showGame;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdGame(): ?Game
    {
        return $this->id_game;
    }

    public function setIdGame(?Game $id_game): self
    {
        $this->id_game = $id_game;

        return $this;
    }
}
