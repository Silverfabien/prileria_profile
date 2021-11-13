<?php

namespace App\Entity\Moderation;

use App\Repository\Moderation\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 *
 * @ORM\Table(name="`tigerreports_reports`")
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="report_id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appreciation;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $reportedUuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reporterUuid;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $reason;

    /**
     * @ORM\Column(type="string", length=22, nullable=true)
     */
    private $reportedIp;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $reportedLocation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reportedMessages;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $reportedGamemode;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $reportedOnGround;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $reportedSneak;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $reportedSprint;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ReportedHealth;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $reportedFood;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reportedEffects;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private $reporterIp;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $reporterLocation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reporterMessages;

    /**
     * @ORM\Column(type="integer")
     */
    private $archived;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAppreciation(): ?string
    {
        return $this->appreciation;
    }

    public function setAppreciation(?string $appreciation): self
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getReportedUuid(): ?string
    {
        return $this->reportedUuid;
    }

    public function setReportedUuid(string $reportedUuid): self
    {
        $this->reportedUuid = $reportedUuid;

        return $this;
    }

    public function getReporterUuid(): ?string
    {
        return $this->reporterUuid;
    }

    public function setReporterUuid(string $reporterUuid): self
    {
        $this->reporterUuid = $reporterUuid;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReportedIp(): ?string
    {
        return $this->reportedIp;
    }

    public function setReportedIp(?string $reportedIp): self
    {
        $this->reportedIp = $reportedIp;

        return $this;
    }

    public function getReportedLocation(): ?string
    {
        return $this->reportedLocation;
    }

    public function setReportedLocation(?string $reportedLocation): self
    {
        $this->reportedLocation = $reportedLocation;

        return $this;
    }

    public function getReportedMessages(): ?string
    {
        return $this->reportedMessages;
    }

    public function setReportedMessages(?string $reportedMessages): self
    {
        $this->reportedMessages = $reportedMessages;

        return $this;
    }

    public function getReportedGamemode(): ?string
    {
        return $this->reportedGamemode;
    }

    public function setReportedGamemode(?string $reportedGamemode): self
    {
        $this->reportedGamemode = $reportedGamemode;

        return $this;
    }

    public function getReportedOnGround(): ?string
    {
        return $this->reportedOnGround;
    }

    public function setReportedOnGround(?string $reportedOnGround): self
    {
        $this->reportedOnGround = $reportedOnGround;

        return $this;
    }

    public function getReportedSneak(): ?string
    {
        return $this->reportedSneak;
    }

    public function setReportedSneak(?string $reportedSneak): self
    {
        $this->reportedSneak = $reportedSneak;

        return $this;
    }

    public function getReportedSprint(): ?string
    {
        return $this->reportedSprint;
    }

    public function setReportedSprint(?string $reportedSprint): self
    {
        $this->reportedSprint = $reportedSprint;

        return $this;
    }

    public function getReportedHealth(): ?string
    {
        return $this->ReportedHealth;
    }

    public function setReportedHealth(?string $ReportedHealth): self
    {
        $this->ReportedHealth = $ReportedHealth;

        return $this;
    }

    public function getReportedFood(): ?string
    {
        return $this->reportedFood;
    }

    public function setReportedFood(?string $reportedFood): self
    {
        $this->reportedFood = $reportedFood;

        return $this;
    }

    public function getReportedEffects(): ?string
    {
        return $this->reportedEffects;
    }

    public function setReportedEffects(?string $reportedEffects): self
    {
        $this->reportedEffects = $reportedEffects;

        return $this;
    }

    public function getReporterIp(): ?string
    {
        return $this->reporterIp;
    }

    public function setReporterIp(string $reporterIp): self
    {
        $this->reporterIp = $reporterIp;

        return $this;
    }

    public function getReporterLocation(): ?string
    {
        return $this->reporterLocation;
    }

    public function setReporterLocation(string $reporterLocation): self
    {
        $this->reporterLocation = $reporterLocation;

        return $this;
    }

    public function getReporterMessages(): ?string
    {
        return $this->reporterMessages;
    }

    public function setReporterMessages(?string $reporterMessages): self
    {
        $this->reporterMessages = $reporterMessages;

        return $this;
    }

    public function getArchived(): ?int
    {
        return $this->archived;
    }

    public function setArchived(int $archived): self
    {
        $this->archived = $archived;

        return $this;
    }
}
