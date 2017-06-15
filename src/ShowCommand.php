<?php

namespace Cli;

use Symfony\Component\Console\{
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface,
    Helper\Table
};


class ShowCommand extends Command
{
    public function configure()
    {
        $this->setName('show')
            ->setDescription('Show all tasks');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->showTasks($output);
    }

}
