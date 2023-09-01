<?php

declare(strict_types=1);

namespace App\Reminder\Receivers\Strategy;

use App\Reminder\Dto\ReceiverResponseDto;
use App\Reminder\Dto\RemindDto;
use App\Reminder\Receivers\ReceiverInterface;

class ReceiverStrategy implements ReceiverInterface
{
    /**
     * @param ReceiverInterface[] $receivers
     * @param ReceiverInterface $defaultReceiver
     */
    public function __construct(private readonly array $receivers, private readonly ReceiverInterface $defaultReceiver)
    {
    }

    /**
     * @param RemindDto $remind
     * @return ReceiverResponseDto
     */
    public function send(RemindDto $remind): ReceiverResponseDto
    {
        if (empty($this->receivers[$remind->getReceiverName()])) {
            return $this->defaultReceiver->send($remind);
        }

        return $this->receivers[$remind->getReceiverName()]->send($remind);
    }
}
