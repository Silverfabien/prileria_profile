<?php

namespace App\Entity\Moderation;

use App\Repository\Moderation\CommentsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 *
 * @ORM\Table(name="`BAT_comments`")
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
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
    private $entity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $staff;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStaff(): ?string
    {
        return $this->staff;
    }

    public function setStaff(string $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
