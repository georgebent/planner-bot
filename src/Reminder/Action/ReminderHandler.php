<?php

declare(strict_types=1);

namespace App\Reminder\Action;

use App\Entity\Job;
use App\Message\RemindMessage;
use App\Reminder\Hydrator\JobToRemindDtoHydrate;
use App\Reminder\Storage\ReminderStorageInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class ReminderHandler.
 */
class ReminderHandler implements RemindersHandlerInterface
{
    public function __construct(
        private readonly ReminderStorageInterface $reminderStorage,
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function handle(\DateTimeImmutable $runningDate): void
    {
        /** @var Job[] $jobs */
        $jobs = $this->reminderStorage->getRemindsForRun($runningDate);

        foreach ($jobs as $job) {
            $dto = JobToRemindDtoHydrate::hydrate($job);

            $this->bus->dispatch(new RemindMessage($dto));
        }
    }
}
