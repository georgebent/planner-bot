<?php

declare(strict_types=1);

namespace App\Reminder\Dto;

class RemindDto
{
    public function __construct(
        private readonly string $receiverName,
        private readonly string $message,
        private readonly string $receiveId,
        private readonly int $jobId,
    )
    {
    }

    public function getReceiverName(): string
    {
        return $this->receiverName;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getReceiveId(): string
    {
        return $this->receiveId;
    }

    public function getJobId(): int
    {
        return $this->jobId;
    }
}
