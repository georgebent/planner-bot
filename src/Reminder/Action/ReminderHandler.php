<?php

declare(strict_types=1);

namespace App\Reminder\Action;

use App\Entity\Job;
use App\Message\RemindMessage;
use App\Reminder\Dto\RemindDto;
use App\Reminder\Storage\ReminderStorageInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class ReminderHandler
 */
class ReminderHandler implements RemindersHandlerInterface
{
    /**
     * @param ReminderStorageInterface $reminderStorage
     * @param MessageBusInterface $bus
     */
    public function __construct(
        private readonly ReminderStorageInterface $reminderStorage,
        private readonly MessageBusInterface $bus,
    )
    {
    }

    /**
     * @param \DateTimeImmutable $runningDate
     * @return void
     */
    public function handle(\DateTimeImmutable $runningDate): void
    {
        /** @var Job[] $jobs */
        $jobs = $this->reminderStorage->getRemindsForRun($runningDate);

        foreach ($jobs as $job) {
            $dto = new RemindDto(
                $job->getUserReceiver()?->getReceiver()?->getName(),
                $job->getMessage(),
                $job->getUserReceiver()->getToken(),
                $job->getId(),
            );

            $this->bus->dispatch(new RemindMessage($dto));
        }
    }
}
