<?php

namespace Tkotosz\CommandScheduler\Request;

class CreateCommandScheduleRequest
{
    /**
     * @var string
     */
    private $commandName;
    
    /**
     * @var array
     */
    private $commandParams;
    
    /**
     * @param string $commandName
     * @param array  $commandParams
     */
    public function __construct(string $commandName, array $commandParams = [])
    {
        $this->commandName = $commandName;
        $this->commandParams = $commandParams;
    }

    public function getCommandName(): string
    {
        return $this->commandName;      
    }

    public function getCommandParams(): array
    {
        return $this->commandParams;
    }
}
