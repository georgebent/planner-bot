<?php

namespace App\Reminder\Hydrator;

use App\Entity\Job;
use App\Reminder\Dto\RemindDto;

class JobToRemindDtoHydrate
{
    public static function hydrate(Job $job): RemindDto
    {
        return new RemindDto(
            (string) $job->getUserReceiver()?->getReceiver()?->getName(),
            (string) $job->getMessage(),
            (string) $job->getUserReceiver()?->getToken(),
            (int) $job->getId(),
        );
    }
}
