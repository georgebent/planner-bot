<?php

declare(strict_types=1);

namespace App\Reminder\Sender;

use App\Reminder\Dto\RemindDto;

/**
 * Interface RemindActionInterface.
 */
interface RemindActionInterface
{
    public function handle(RemindDto $remindDto): void;
}
