<?php

declare(strict_types=1);

namespace App\Reminder\Storage;

interface ReminderStorageInterface
{
    public function getRemindsForRun(\DateTimeImmutable $date);
}
