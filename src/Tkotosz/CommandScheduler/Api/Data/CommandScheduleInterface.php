<?php

namespace Tkotosz\CommandScheduler\Api\Data;

interface CommandScheduleInterface
{
    public const SCHEDULE_ID = 'schedule_id';
    public const COMMAND_NAME = 'command_name';
    public const COMMAND_PARAMS = 'command_params';
    public const STATUS = 'status';
    public const RESULT = 'result';
    public const SCHEDULED_AT = 'scheduled_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getScheduleId(): ?int;

    /**
     * @param int $scheduleId
     * @return CommandScheduleInterface
     */
    public function setScheduleId($scheduleId): CommandScheduleInterface;

    /**
     * @return string|null
     */
    public function getCommandName(): ?string;

    /**
     * @param string $commandName
     * @return CommandScheduleInterface
     */
    public function setCommandName(string $commandName): CommandScheduleInterface;

    /**
     * @return string|null
     */
    public function getCommandParams(): ?string;

    /**
     * @param string $commandParams
     * @return CommandScheduleInterface
     */
    public function setCommandParams(string $commandParams): CommandScheduleInterface;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @param string $status
     * @return CommandScheduleInterface
     */
    public function setStatus(string $status): CommandScheduleInterface;

    /**
     * @return string|null
     */
    public function getResult(): ?string;

    /**
     * @param string $result
     * @return CommandScheduleInterface
     */
    public function setResult(string $result): CommandScheduleInterface;

    /**
     * @return string|null
     */
    public function getScheduledAt(): ?string;

    /**
     * @param string $scheduledAt
     * @return CommandScheduleInterface
     */
    public function setScheduledAt(string $scheduledAt): CommandScheduleInterface;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param string $updatedAt
     * @return CommandScheduleInterface
     */
    public function setUpdatedAt(string $updatedAt): CommandScheduleInterface;
}
