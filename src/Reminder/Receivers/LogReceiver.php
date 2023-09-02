<?php

declare(strict_types=1);

namespace App\Reminder\Receivers;

use App\Reminder\Dto\ReceiverResponseDto;
use App\Reminder\Dto\RemindDto;
use Psr\Log\LoggerInterface;

class LogReceiver implements ReceiverInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function send(RemindDto $remind): ReceiverResponseDto
    {
        $this->logger->warning(
            sprintf(
                'Message(%d): "%s" to %s. Receiver: %s',
                $remind->getJobId(),
                $remind->getMessage(),
                $remind->getReceiveId(),
                $remind->getReceiverName(),
            )
        );

        return new ReceiverResponseDto('Log created successfully');
    }
}
