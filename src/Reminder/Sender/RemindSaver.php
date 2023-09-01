<?php

declare(strict_types=1);

namespace App\Reminder\Sender;

use App\Entity\Job;
use App\Reminder\Dto\RemindDto;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class RemindSaver extends RemindActionHandler
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
     */
    protected function process(RemindDto $remindDto): bool
    {
        $job = $this->entityManager->getRepository(Job::class)->find($remindDto->getJobId());
        if (empty($job)) {
            $this->logger->error(sprintf('Job id %d save failed, reason: not found', $remindDto->getJobId()));

            return false;
        }

        $job->setLastSentAt($job->getSendAt());
        $job->setSentTimes($job->getSentTimes() + 1);

        $this->entityManager->persist($job);
        $this->entityManager->flush();

        return true;
    }
}
