<?php

namespace App\Reminder\Sender;

use App\Reminder\Dto\RemindDto;

abstract class RemindActionHandler implements RemindActionInterface
{
    protected ?RemindActionInterface $handler = null;

    final public function handle(RemindDto $remindDto): void
    {
        $result = $this->process($remindDto);

        if (empty($this->handler) || !$result) {
            return;
        }

        $this->handler->handle($remindDto);
    }

    abstract protected function process(RemindDto $remindDto): bool;
}
