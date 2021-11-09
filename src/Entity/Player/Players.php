<?php

namespace App\Entity\Player;

use App\Repository\Player\PlayersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayersRepository::class)
 *
 * @ORM\Table(name="`BAT_players`")
 */
class Players
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, name="BAT_player")
     */
    private $batPlayer;

    /**
     * @ORM\Column(type="string", length=100, name="UUID")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastip;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $firstlogin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastlogin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatPlayer(): ?string
    {
        return $this->batPlayer;
    }

    public function setBatPlayer(string $batPlayer): self
    {
        $this->batPlayer = $batPlayer;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getLastip(): ?string
    {
        return $this->lastip;
    }

    public function setLastip(string $lastip): self
    {
        $this->lastip = $lastip;

        return $this;
    }

    public function getFirstlogin(): ?\DateTimeInterface
    {
        return $this->firstlogin;
    }

    public function setFirstlogin(?\DateTimeInterface $firstlogin): self
    {
        $this->firstlogin = $firstlogin;

        return $this;
    }

    public function getLastlogin(): ?\DateTimeInterface
    {
        return $this->lastlogin;
    }

    public function setLastlogin(\DateTimeInterface $lastlogin): self
    {
        $this->lastlogin = $lastlogin;

        return $this;
    }
}
