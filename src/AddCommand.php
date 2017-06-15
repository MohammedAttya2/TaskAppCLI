<?php

namespace Cli;

use Symfony\Component\Console\{
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface,
    Helper\Table
};


class AddCommand extends Command
{
    public function configure()
    {
        $this->setName('add')
            ->setDescription('Add a new task')
            ->addArgument('descreption', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $descreption = $input->getArgument('descreption');
        $this->database->query(
            'insert into tasks (descreption) values (:descreption)',
            compact('descreption')
        );

        $output->writeln('<info>Task added!</info>');

        $this->showTasks($output);
    }

}
