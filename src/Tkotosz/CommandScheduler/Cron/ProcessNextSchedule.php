<?php

namespace Tkotosz\CommandScheduler\Cron;

use Tkotosz\CommandScheduler\Model\CommandScheduleProcessor;

class ProcessNextSchedule
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
        $this->commandScheduleProcessor = $commandScheduleProcessor;
    }

    public function execute()
    {
        $this->commandScheduleProcessor->processNext();
    }
}
