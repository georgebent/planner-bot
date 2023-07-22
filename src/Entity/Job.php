<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserReceiver $userReceiver = null;

    #[ORM\ManyToOne]
    private ?Interval $interval = null;

    #[ORM\Column]
    private ?int $sentTimes = null;

    #[ORM\Column]
    private ?int $maxTimes = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastSentAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sendAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getUserReceiver(): ?UserReceiver
    {
        return $this->userReceiver;
    }

    public function setUserReceiver(?UserReceiver $userReceiver): static
    {
        $this->userReceiver = $userReceiver;

        return $this;
    }

    public function getInterval(): ?Interval
    {
        return $this->interval;
    }

    public function setInterval(?Interval $interval): static
    {
        $this->interval = $interval;

        return $this;
    }

    public function getSentTimes(): ?int
    {
        return $this->sentTimes;
    }

    public function setSentTimes(int $sentTimes): static
    {
        $this->sentTimes = $sentTimes;

        return $this;
    }

    public function getMaxTimes(): ?int
    {
        return $this->maxTimes;
    }

    public function setMaxTimes(int $maxTimes): static
    {
        $this->maxTimes = $maxTimes;

        return $this;
    }

    public function getLastSentAt(): ?\DateTimeImmutable
    {
        return $this->lastSentAt;
    }

    public function setLastSentAt(\DateTimeImmutable $lastSentAt): static
    {
        $this->lastSentAt = $lastSentAt;

        return $this;
    }

    public function getSendAt(): ?\DateTimeImmutable
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeImmutable $sendAt): static
    {
        $this->sendAt = $sendAt;

        return $this;
    }
}
