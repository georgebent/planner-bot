<?php

declare(strict_types=1);

namespace App\Reminder\Sender;

use App\Entity\Job;
use App\Reminder\Dto\RemindDto;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class RemindNextCreator extends RemindActionHandler
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     * @param RemindActionInterface|null $handler
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        ?RemindActionInterface $handler = null,
    )
    {
        $this->handler = $handler;
    }

    /**
     * @param RemindDto $remindDto
     * @return bool
     * @throws \Exception
     */
    protected function process(RemindDto $remindDto): bool
    {
        $job = $this->entityManager->getRepository(Job::class)->find($remindDto->getJobId());
        if (empty($job)) {
            $this->logger->error(sprintf('Job id %d next create failed, reason: not found', $remindDto->getJobId()));

            return false;
        }

        if (!$job->getInterval() || $job->getSentTimes() >= $job->getMaxTimes()) {
            return true;
        }

        $newDate = $job->getSendAt()->modify('+ ' . $job->getInterval()->getPattern());
        $job->setSendAt($newDate);

        $this->entityManager->persist($job);
        $this->entityManager->flush();

        $this->logger->info(
            sprintf('Job id %d next create set to: %s', $remindDto->getJobId(), $newDate->format('Y-m-d H:i')),
        );


        return true;
    }
}
