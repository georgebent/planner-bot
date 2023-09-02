<?php

declare(strict_types=1);

namespace App\Reminder\Receivers;

use App\Reminder\Dto\ReceiverResponseDto;
use App\Reminder\Dto\RemindDto;
use Psr\Log\LoggerInterface;
use TelegramBot\Request;
use TelegramBot\Telegram;

class TelegramReceiver implements ReceiverInterface
{
    public function __construct(private readonly LoggerInterface $logger, private readonly string $telegramToken)
    {
    }

    public function send(RemindDto $remind): ReceiverResponseDto
    {
        Telegram::setToken($this->telegramToken);
        $result = Request::sendMessage([
            'chat_id' => $remind->getReceiveId(),
            'text' => $remind->getMessage(),
        ]);

        $result->isOk();
        $responseMessage = json_encode($result->getResult());

        $this->logger->info(
            sprintf(
                'Message(%d): "%s" to %s. Receiver: %s. Response: %s',
                $remind->getJobId(),
                $remind->getMessage(),
                $remind->getReceiveId(),
                $remind->getReceiverName(),
                $responseMessage,
            )
        );

        return new ReceiverResponseDto($responseMessage, $result->isOk());
    }
}
