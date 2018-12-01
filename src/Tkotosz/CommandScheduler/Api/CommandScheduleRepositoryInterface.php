<?php

namespace Tkotosz\CommandScheduler\Api;

use Tkotosz\CommandScheduler\Api\Data\CommandScheduleInterface;
use Tkotosz\CommandScheduler\Api\Data\CommandScheduleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria;

interface CommandScheduleRepositoryInterface
{
    public function save(CommandScheduleInterface $commandSchedule): CommandScheduleInterface;

    public function create(string $commandName, string $commandParams): CommandScheduleInterface;

    public function updateStatus(CommandScheduleInterface $commandSchedule, string $status): CommandScheduleInterface;

    public function updateResult(CommandScheduleInterface $commandSchedule, string $result): CommandScheduleInterface;

    public function getById(int $id): CommandScheduleInterface;

    public function getList(SearchCriteria $searchCriteria): CommandScheduleSearchResultsInterface;

    public function getOneByStatus(string $status): ?CommandScheduleInterface;

    public function getAll(): CommandScheduleSearchResultsInterface;

    public function delete(CommandScheduleInterface $commandSchedule): bool;

    public function deleteById(int $id): bool;
}
