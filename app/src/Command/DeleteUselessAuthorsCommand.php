<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\DeleteBooks;

#[AsCommand(
    name: 'app:delete-useless-authors', 
    description: 'Deleting authors without books')]
class DeleteUselessAuthorsCommand extends Command
{
    public function __construct(
        private DeleteBooks $deleteBooks,
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->deleteBooks->delete();

        if ($result) {
            $output->writeln('Books without authors deleted!');
            return Command::SUCCESS;
        } else {
            $output->writeln('Not such books');
            return Command::FAILURE;
        }

    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to delete authors who hasn\'t books');
    }
}
