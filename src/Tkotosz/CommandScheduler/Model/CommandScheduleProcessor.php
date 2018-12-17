<?php

namespace Tkotosz\CommandScheduler\Model;

use Tkotosz\CommandScheduler\Api\CommandScheduleRepositoryInterface;
use Tkotosz\CommandScheduler\Model\CommandProvider;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

class CommandScheduleProcessor
{
    /**
     * @var CommandScheduleRepositoryInterface
     */
    private $commandScheduleRepository;
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * @var CommandProvider
     */
    private $commandProvider;
    
    /**
     * @param CommandScheduleRepositoryInterface $commandScheduleRepository
     * @param LoggerInterface           $logger
     * @param CommandProvider           $commandProvider
     */
    public function __construct(
        CommandScheduleRepositoryInterface $commandScheduleRepository,
        LoggerInterface $logger,
        CommandProvider $commandProvider
    ) {
        $this->commandScheduleRepository = $commandScheduleRepository;
        $this->logger = $logger;
        $this->commandProvider = $commandProvider;
    }
    
    public function processNext(): string
    {
        $schedule = $this->commandScheduleRepository->getOneByStatus('pending');

        if ($schedule === null) {
            return 'no pending schedule';
        }

        try {
            $this->commandScheduleRepository->updateStatus($schedule, 'running');

            $command = $this->commandProvider->getByName($schedule->getCommandName());

            if ($command === null) {
                throw new \Exception(sprintf('Invalid command: "%s"', $schedule->getCommandName()));
            }

            if (!empty($schedule->getCommandParams())) {
                if ($command->getApplication() !== null) {
                    $input = new StringInput($schedule->getCommandName() . ' ' . $schedule->getCommandParams());
                } else {
                    $input = new StringInput($schedule->getCommandParams());
                }
            } else {
                $input = new ArrayInput([]);
            }
            $output = new BufferedOutput();

            $command->run($input, $output);
            $result = $output->fetch();

            $this->commandScheduleRepository->updateStatus($schedule, 'done');
            $this->commandScheduleRepository->updateResult($schedule, $result);

            return $result;
        } catch (\Exception $e) {
            $this->logger->critical($e);

            $this->commandScheduleRepository->updateStatus($schedule, 'failed');
            $this->commandScheduleRepository->updateResult($schedule, $e->getMessage());

            return $e->getMessage();
        }
    }
}
