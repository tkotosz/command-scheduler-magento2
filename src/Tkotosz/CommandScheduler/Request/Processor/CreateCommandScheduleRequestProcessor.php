<?php

namespace Tkotosz\CommandScheduler\Request\Processor;

use Tkotosz\CommandScheduler\Api\CommandScheduleRepositoryInterface;
use Tkotosz\CommandScheduler\Api\Data\CommandScheduleInterface;
use Tkotosz\CommandScheduler\Model\CommandProvider;
use Tkotosz\CommandScheduler\Request\CreateCommandScheduleRequest;

class CreateCommandScheduleRequestProcessor
{
    /**
     * @var CommandScheduleRepositoryInterface
     */
    private $commandScheduleRepository;
    
    /**
     * @var CommandProvider
     */
    private $commandProvider;
    
    /**
     * @param CommandScheduleRepositoryInterface $commandScheduleRepository
     * @param CommandProvider                    $commandProvider
     */
    public function __construct(
        CommandScheduleRepositoryInterface $commandScheduleRepository,
        CommandProvider $commandProvider
    ) {
        $this->commandScheduleRepository = $commandScheduleRepository;
        $this->commandProvider = $commandProvider;
    }
    
    public function process(CreateCommandScheduleRequest $request): CommandScheduleInterface
    {
        return $this->commandScheduleRepository->create($request->getCommandName(), $this->createCommandInput($request));
    }

    private function createCommandInput(CreateCommandScheduleRequest $request): string
    {
        $input = '';
        
        $command = $this->commandProvider->getByName($request->getCommandName());
        $commandParams = $request->getCommandParams();
        
        // add options
        foreach ($command->getDefinition()->getOptions() as $option) {
            $paramName = sprintf('--%s', $option->getName());
            if (isset($commandParams[$paramName])) {
                $input .= sprintf(
                    ' %s="%s"',
                    $paramName,
                    addcslashes($commandParams[$paramName], '"')
                );
            }
        }

        // add arguments
        foreach ($command->getDefinition()->getArguments() as $argument) {
            $paramName = $argument->getName();
            if (isset($commandParams[$paramName])) {
                $input .= sprintf(
                    ' "%s"',
                    addcslashes($commandParams[$paramName], '"')
                );
            }
        }

        return trim($input);
    }
}
