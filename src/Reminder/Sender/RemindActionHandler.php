<?php

namespace App\Reminder\Sender;

use App\Reminder\Dto\RemindDto;

abstract class RemindActionHandler implements RemindActionInterface
{
    /**
     * @var RemindActionInterface|null
     */
    protected ?RemindActionInterface $handler = null;

    /**
     * @param RemindDto $remindDto
     * @return void
     */
    final public function handle(RemindDto $remindDto): void
    {
        $result = $this->process($remindDto);

        if (empty($this->handler) || !$result) {
            return;
        }

        $this->handler->handle($remindDto);
    }

    /**
     * @param RemindDto $remindDto
     * @return bool
     */
    abstract protected function process(RemindDto $remindDto): bool;
}
