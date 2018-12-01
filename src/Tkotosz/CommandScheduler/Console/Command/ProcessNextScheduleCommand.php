<?php

namespace Tkotosz\CommandScheduler\Console\Command;

use Tkotosz\CommandScheduler\Model\CommandScheduleProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessNextScheduleCommand extends Command
{
    /**
     * @var CommandScheduleProcessor
     */
    private $commandScheduleProcessor;
    
    /**
     * @param CommandScheduleProcessor $commandScheduleProcessor
     */
    public function __construct(CommandScheduleProcessor $commandScheduleProcessor)
    {
        parent::__construct();

        $this->commandScheduleProcessor = $commandScheduleProcessor;
    }
    
    protected function configure()
    {
        $this->setName('command-scheduler:process-next-schedule')
            ->setDescription('Processes the next pending schedule');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->commandScheduleProcessor->processNext();

        $output->writeln($result);
    }
}
