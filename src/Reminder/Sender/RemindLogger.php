<?php

declare(strict_types=1);

namespace App\Reminder\Sender;

use App\Reminder\Dto\RemindDto;
use Psr\Log\LoggerInterface;

class RemindLogger extends RemindActionHandler
{
    /**
     * @param LoggerInterface $logger
     * @param RemindActionInterface|null $handler
     */
    public function __construct(
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
        $this->logger->info(sprintf('Job id %d save successfully', $remindDto->getJobId()));

        return true;
    }
}
