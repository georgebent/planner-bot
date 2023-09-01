<?php

namespace App\MessageHandler;

use App\Message\RemindMessage;
use App\Reminder\Action\RemindSendHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RemindMessageHandler
{
    public function __construct(private readonly RemindSendHandlerInterface $remindSendHandler)
    {
    }

    public function __invoke(RemindMessage $message): void
    {
        $this->remindSendHandler->handle($message->getRemindDto());
    }
}
