<?php

declare(strict_types=1);

namespace App\Reminder\Receivers;

use App\Reminder\Dto\ReceiverResponseDto;
use App\Reminder\Dto\RemindDto;

interface ReceiverInterface
{
    public function send(RemindDto $remind): ReceiverResponseDto;
}
