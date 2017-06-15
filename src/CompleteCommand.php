<?php

namespace Cli;

use Symfony\Component\Console\{
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface,
    Helper\Table
};


class CompleteCommand extends Command
{
    public function configure()
    {
        $this->setName('complete')
            ->setDescription('Complete task by its id')
            ->addArgument('id', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        $this->database->query('delete from tasks where id = :id', compact('id'));

        $output->writeln('<info>Task completed!</info>');
        $this->showTasks($output);
    }

}
