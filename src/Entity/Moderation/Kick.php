<?php

namespace App\Entity\Moderation;

use App\Repository\Moderation\KickRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KickRepository::class)
 *
 * @ORM\Table(name="`BAT_kick`")
 */
class Kick
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="kick_id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, name="UUID")
     *
     * @Assert\Regex(
     *     pattern="/^[a-z0-9]+$/",
     *     message="L'uuid de doit pas contenir de ' - '."
     * )
     * @Assert\Length(
     *     max=32,
     *     min=32,
     *     exactMessage="L'uuid doit contenir uniquement {{ limit }} caractères. Ex : af860b2e418411ec81d30242ac130003"
     * )
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $kickStaff;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $kickReason;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $kickServer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $kickDate;

    public function __construct()
    {
        $this->kickDate = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getKickStaff(): ?string
    {
        return $this->kickStaff;
    }

    public function setKickStaff(string $kickStaff): self
    {
        $this->kickStaff = $kickStaff;

        return $this;
    }

    public function getKickReason(): ?string
    {
        return $this->kickReason;
    }

    public function setKickReason(?string $kickReason): self
    {
        $this->kickReason = $kickReason;

        return $this;
    }

    public function getKickServer(): ?string
    {
        return $this->kickServer;
    }

    public function setKickServer(string $kickServer): self
    {
        $this->kickServer = $kickServer;

        return $this;
    }

    public function getKickDate(): ?\DateTimeInterface
    {
        return $this->kickDate;
    }

    public function setKickDate(\DateTimeInterface $kickDate): self
    {
        $this->kickDate = $kickDate;

        return $this;
    }
}
