<?php

declare(strict_types=1);

namespace App\Reminder\Sender;

use App\Reminder\Dto\RemindDto;
use App\Reminder\Receivers\ReceiverInterface;
use Psr\Log\LoggerInterface;

class RemindSender extends RemindActionHandler
{
    public function __construct(
        private readonly ReceiverInterface $receiver,
        private readonly LoggerInterface $logger,
        RemindActionInterface $handler = null,
    ) {
        $this->handler = $handler;
    }

    protected function process(RemindDto $remindDto): bool
    {
        $result = $this->receiver->send($remindDto);
        if (!$result->isSuccess()) {
            $this->logger->error(
                sprintf('Job id %d send failed, reason: %s', $remindDto->getJobId(), $result->getMessage())
            );
        }

        return $result->isSuccess();
    }
}
