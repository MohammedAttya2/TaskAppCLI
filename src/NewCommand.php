<?php

namespace Cli;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface
};
use GuzzleHttp\ClientInterface;
use ZipArchive;

class NewCommand extends Command
{
    private $client;

    function __construct(ClientInterface $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('new')
            ->setDescription('Create a new Laravel application')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Crafting Application...</info>');
        $directory = getcwd() . '/' . $input->getArgument('name');
        $this->assertApplicationDoesntExist($directory, $output);

        $this->download($zipFile = $this->getFileName())
            ->extractZip($zipFile, $directory)
            ->cleanUp($zipFile);

        $output->writeln('<comment>Application ready!!!!</comment>');
        

    }

    private function getFileName()
    {
        return getcwd() . '/laravel_' . md5(time().uniqid()) . '.zip';
    }

    private function download($zipFile)
    {
        $respons = $this->client->get('http://cabinet.laravel.com/latest.zip')->getBody();
        file_put_contents($zipFile, $respons);
        return $this;
    }

    private function extractZip($zipFile, $directory)
    {
        $archive = new ZipArchive;
        $archive->open($zipFile);
        $archive->extractTo($directory);
        $archive->close();
        return $this;
    }

    private function cleanUp($zipFile)
    {
        @chmod($zipFile, 0777);
        @unlink($zipFile);

        return $this;
    }

    private function assertApplicationDoesntExist($directory, OutputInterface $output)
    {
        if (is_dir($directory)) {
            $output->writeln('<error>Application already exist</error>');
            exit(1);
        }
    }
}
