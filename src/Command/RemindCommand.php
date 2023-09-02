<?php

namespace App\Command;

use App\Reminder\Action\RemindersHandlerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function Symfony\Component\Clock\now;

#[AsCommand(
    name: 'app:remind:run',
    description: 'Run reminder',
)]
class RemindCommand extends Command
{
    public function __construct(private readonly RemindersHandlerInterface $remindersHandler, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // $date = new \DateTimeImmutable();
        // $date = $date->setDate(2023, 12, 31)->setTime(10, 0, 21);
        // $this->remindersHandler->handle($date);

        $this->remindersHandler->handle(now());
        $io->success('Reminder run');

        return Command::SUCCESS;
    }
}
