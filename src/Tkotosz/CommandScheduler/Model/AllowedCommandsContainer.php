<?php

namespace Tkotosz\CommandScheduler\Model;

use Tkotosz\CommandScheduler\Model\CommandProvider;

class AllowedCommandsContainer
{
    /**
     * @var array
     */
    private $allowedCommands;
    
    /**
     * @param array $allowedCommands
     */
    public function __construct(array $allowedCommands = [])
    {
        $this->allowedCommands = $allowedCommands;
    }
    
    public function getAllowedCommands(): array
    {
        return $this->allowedCommands;
    }

    public function hasCommand(string $commandName): bool
    {
        return array_search($commandName, $this->allowedCommands) !== false;
    }
}
