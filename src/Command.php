<?php

namespace Cli;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\{
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface,
    Helper\Table
};


class Command extends SymfonyCommand
{
    protected $database;

    function __construct(DatabaseAdapter $database)
    {
        $this->database = $database;

        parent::__construct();
    }

    protected function showTasks(OutputInterface $output)
    {
        if (!$tasks = $this->database->fetchAll('tasks'))
        {
            return $output->writeln('<info>No tasks at the moment!</info>');
        }
        $table = new Table($output);

        $table->setHeaders(['Id', 'Description'])
            ->setRows($tasks)
            ->render();
    }

}
