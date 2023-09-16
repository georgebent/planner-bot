<?php

namespace App\Command;

use App\Entity\Receiver;
use App\Entity\User;
use App\Entity\UserReceiver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Add user command',
)]
class AddUserCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
            ->addArgument('telegram', InputArgument::REQUIRED, 'Telegram')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $telegram = $input->getArgument('telegram');

        $telegramReceiver = $this->entityManager->getRepository(Receiver::class)->findOneBy(['name' => 'telegram']);

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('pass');

        $userReceiver = new UserReceiver();
        $userReceiver->setToken($telegram);
        $userReceiver->setReceiver($telegramReceiver);
        $userReceiver->setAuthor($user);


        $this->entityManager->persist($userReceiver);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
