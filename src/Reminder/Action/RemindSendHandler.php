<?php

declare(strict_types=1);

namespace App\Reminder\Action;

use App\Reminder\Dto\RemindDto;
use App\Reminder\Sender\RemindActionInterface;

class RemindSendHandler implements RemindSendHandlerInterface
{
    public function __construct(private readonly RemindActionInterface $remindAction)
    {
    }

    public function handle(RemindDto $remind): void
    {
        $this->remindAction->handle($remind);
    }
}
