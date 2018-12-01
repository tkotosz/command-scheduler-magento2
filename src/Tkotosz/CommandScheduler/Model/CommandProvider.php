<?php

namespace Tkotosz\CommandScheduler\Model;

use Magento\Framework\Console\CommandList\Proxy as CommandList;
use Symfony\Component\Console\Command\Command;
use Tkotosz\CommandScheduler\Model\AllowedCommandsContainer;

class CommandProvider
{
    /**
     * @var CommandList
     */
    private $commandList;
    
    /**
     * @var AllowedCommandsContainer
     */
    private $allowedCommandsContainer;
    
    /**
     * @param CommandList              $commandList
     * @param AllowedCommandsContainer $allowedCommandsContainer
     */
    public function __construct(CommandList $commandList, AllowedCommandsContainer $allowedCommandsContainer)
    {
        $this->commandList = $commandList;
        $this->allowedCommandsContainer = $allowedCommandsContainer;
    }
    
    public function getByName(string $name): ?Command
    {
        foreach ($this->commandList->getCommands() as $command) {
            if ($command->getName() === $name && $this->allowedCommandsContainer->hasCommand($command->getName())) {
                return $command;
            }
        }

        return null;
    }
}
