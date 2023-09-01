<?php

declare(strict_types=1);

namespace App\Reminder\Action;

interface RemindersHandlerInterface
{
    public function handle(\DateTimeImmutable $runningDate): void;
}
