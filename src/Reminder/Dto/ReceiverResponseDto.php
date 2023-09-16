<?php

declare(strict_types=1);

namespace App\Reminder\Dto;

class ReceiverResponseDto
{
    public function __construct(private readonly string $message, private readonly bool $isSuccess = true)
    {
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
