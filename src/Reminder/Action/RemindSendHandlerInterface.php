<?php

declare(strict_types=1);

namespace App\Reminder\Action;

use App\Reminder\Dto\RemindDto;

interface RemindSendHandlerInterface
{
    public function handle(RemindDto $remind): void;
}
