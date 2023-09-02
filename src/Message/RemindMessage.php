<?php

namespace App\Message;

use App\Reminder\Dto\RemindDto;

class RemindMessage
{
    public function __construct(private readonly RemindDto $remindDto)
    {
    }

    public function getRemindDto(): RemindDto
    {
        return $this->remindDto;
    }
}
