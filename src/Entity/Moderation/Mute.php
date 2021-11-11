<?php

namespace App\Entity\Moderation;

use App\Repository\Moderation\MuteRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MuteRepository::class)
 *
 * @ORM\Table(name="`BAT_mute`")
 */
class Mute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="mute_id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="UUID")
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
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Ip(message="Le format de l'ip n'est pas reconnu. Ex: 95.165.32.158")
     */
    private $muteIp;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $muteStaff;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Length(
     *     max=100,
     *     maxMessage="La raison ne doit pas dépasser {{ limit }} caractères."
     * )
     */
    private $muteReason;

    /**
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\Regex(
     *     pattern="/\([^()]+\)/",
     *     message="Le serveur doit être mit sous forme => (nomDuServeur)."
     * )
     *
     * @Assert\Length(
     *     max=30,
     *     maxMessage="Le nom du serveur ne doit pas dépasser {{ limit }} caractères."
     * )
     */
    private $muteServer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $muteBegin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $muteEnd;

    /**
     * @ORM\Column(type="integer")
     */
    private $muteState;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $muteUnmutedate;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $muteUnmutestaff;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $muteUnmutereason;

    public function __construct()
    {
        $this->muteBegin = new DateTimeImmutable();
        $this->muteState = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getMuteIp(): ?string
    {
        return $this->muteIp;
    }

    public function setMuteIp(?string $muteIp): self
    {
        $this->muteIp = $muteIp;

        return $this;
    }

    public function getMuteStaff(): ?string
    {
        return $this->muteStaff;
    }

    public function setMuteStaff(string $muteStaff): self
    {
        $this->muteStaff = $muteStaff;

        return $this;
    }

    public function getMuteReason(): ?string
    {
        return $this->muteReason;
    }

    public function setMuteReason(?string $muteReason): self
    {
        $this->muteReason = $muteReason;

        return $this;
    }

    public function getMuteServer(): ?string
    {
        return $this->muteServer;
    }

    public function setMuteServer(string $muteServer): self
    {
        $this->muteServer = $muteServer;

        return $this;
    }

    public function getMuteBegin(): ?\DateTimeInterface
    {
        return $this->muteBegin;
    }

    public function setMuteBegin(\DateTimeInterface $muteBegin): self
    {
        $this->muteBegin = $muteBegin;

        return $this;
    }

    public function getMuteEnd(): ?\DateTimeInterface
    {
        return $this->muteEnd;
    }

    public function setMuteEnd(?\DateTimeInterface $muteEnd): self
    {
        $this->muteEnd = $muteEnd;

        return $this;
    }

    public function getMuteState(): ?int
    {
        return $this->muteState;
    }

    public function setMuteState(int $muteState): self
    {
        $this->muteState = $muteState;

        return $this;
    }

    public function getMuteUnmutedate(): ?\DateTimeInterface
    {
        return $this->muteUnmutedate;
    }

    public function setMuteUnmutedate(?\DateTimeInterface $muteUnmutedate): self
    {
        $this->muteUnmutedate = $muteUnmutedate;

        return $this;
    }

    public function getMuteUnmutestaff(): ?string
    {
        return $this->muteUnmutestaff;
    }

    public function setMuteUnmutestaff(?string $muteUnmutestaff): self
    {
        $this->muteUnmutestaff = $muteUnmutestaff;

        return $this;
    }

    public function getMuteUnmutereason(): ?string
    {
        return $this->muteUnmutereason;
    }

    public function setMuteUnmutereason(string $muteUnmutereason): self
    {
        $this->muteUnmutereason = $muteUnmutereason;

        return $this;
    }
}
