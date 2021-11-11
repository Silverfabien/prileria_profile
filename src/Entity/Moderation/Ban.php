<?php

namespace App\Entity\Moderation;

use App\Repository\Moderation\BanRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BanRepository::class)
 *
 * @ORM\Table(name="`BAT_ban`")
 */
class Ban
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="ban_id")
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
    private $banIp;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $banStaff;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Length(
     *     max=100,
     *     maxMessage="La raison ne doit pas dépasser {{ limit }} caractères."
     * )
     */
    private $banReason;

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
    private $banServer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $banBegin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $banEnd;

    /**
     * @ORM\Column(type="integer")
     */
    private $banState;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $banUnbandate;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $banUnbanstaff;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $banUnbanreason;

    public function __construct()
    {
        $this->banBegin = new DateTimeImmutable();
        $this->banState = 1;
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

    public function getBanIp(): ?string
    {
        return $this->banIp;
    }

    public function setBanIp(?string $banIp): self
    {
        $this->banIp = $banIp;

        return $this;
    }

    public function getBanStaff(): ?string
    {
        return $this->banStaff;
    }

    public function setBanStaff(string $banStaff): self
    {
        $this->banStaff = $banStaff;

        return $this;
    }

    public function getBanReason(): ?string
    {
        return $this->banReason;
    }

    public function setBanReason(?string $banReason): self
    {
        $this->banReason = $banReason;

        return $this;
    }

    public function getBanServer(): ?string
    {
        return $this->banServer;
    }

    public function setBanServer(string $banServer): self
    {
        $this->banServer = $banServer;

        return $this;
    }

    public function getBanBegin(): ?\DateTimeInterface
    {
        return $this->banBegin;
    }

    public function setBanBegin(\DateTimeInterface $banBegin): self
    {
        $this->banBegin = $banBegin;

        return $this;
    }

    public function getBanEnd(): ?\DateTimeInterface
    {
        return $this->banEnd;
    }

    public function setBanEnd(?\DateTimeInterface $banEnd): self
    {
        $this->banEnd = $banEnd;

        return $this;
    }

    public function getBanState(): ?int
    {
        return $this->banState;
    }

    public function setBanState(int $banState): self
    {
        $this->banState = $banState;

        return $this;
    }

    public function getBanUnbandate(): ?\DateTimeInterface
    {
        return $this->banUnbandate;
    }

    public function setBanUnbandate(?\DateTimeInterface $banUnbandate): self
    {
        $this->banUnbandate = $banUnbandate;

        return $this;
    }

    public function getBanUnbanstaff(): ?string
    {
        return $this->banUnbanstaff;
    }

    public function setBanUnbanstaff(?string $banUnbanstaff): self
    {
        $this->banUnbanstaff = $banUnbanstaff;

        return $this;
    }

    public function getBanUnbanreason(): ?string
    {
        return $this->banUnbanreason;
    }

    public function setBanUnbanreason(?string $banUnbanreason): self
    {
        $this->banUnbanreason = $banUnbanreason;

        return $this;
    }
}
