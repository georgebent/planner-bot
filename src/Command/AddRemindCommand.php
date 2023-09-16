<?php

namespace App\Command;

use App\Entity\Job;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:remind:create',
    description: 'Add a remind',
)]
class AddRemindCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'email')
            ->addArgument('message', InputArgument::REQUIRED, 'message')
            ->addArgument('send_at', InputArgument::REQUIRED, 'send_at')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $message = $input->getArgument('message');
        $sendAt = \DateTimeImmutable::createFromFormat('Y-m-d\\TH:i:s', $input->getArgument('send_at'));

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        $job = new Job();
        $job->setMessage($message);
        $job->setSendAt($sendAt);
        $job->setSentTimes(0);
        $job->setMaxTimes(1);
        $job->setUserReceiver($user->getUserReceivers()->first());

        $this->entityManager->persist($job);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
