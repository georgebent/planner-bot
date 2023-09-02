<?php

declare(strict_types=1);

namespace App\Reminder\Sender;

use App\Reminder\Dto\RemindDto;
use Psr\Log\LoggerInterface;

class RemindLogger extends RemindActionHandler
{
    public function __construct(
        private readonly LoggerInterface $logger,
        RemindActionInterface $handler = null,
    ) {
        $this->handler = $handler;
    }

    protected function process(RemindDto $remindDto): bool
    {
        $this->logger->info(sprintf('Job id %d finished successfully', $remindDto->getJobId()));

        return true;
    }
}
