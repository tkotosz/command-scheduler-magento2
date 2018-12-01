<?php

namespace Tkotosz\CommandScheduler\Model;

use Tkotosz\CommandScheduler\Api\Data\CommandScheduleInterface;
use Tkotosz\CommandScheduler\Model\ResourceModel\CommandSchedule as CommandScheduleResource;
use Magento\Framework\Model\AbstractModel;

class CommandSchedule extends AbstractModel implements CommandScheduleInterface
{
    /**
     * @return int|null
     */
    public function getScheduleId(): ?int
    {
        return $this->getData(self::SCHEDULE_ID);
    }

    /**
     * @param int $scheduleId
     * @return CommandScheduleInterface
     */
    public function setScheduleId($scheduleId): CommandScheduleInterface
    {
        return $this->setData(self::SCHEDULE_ID, $scheduleId);
    }

    /**
     * @return string|null
     */
    public function getCommandName(): ?string
    {
        return $this->getData(self::COMMAND_NAME);
    }

    /**
     * @param string $commandName
     * @return CommandScheduleInterface
     */
    public function setCommandName(string $commandName): CommandScheduleInterface
    {
        return $this->setData(self::COMMAND_NAME, $commandName);
    }

    /**
     * @return string|null
     */
    public function getCommandParams(): ?string
    {
        return $this->getData(self::COMMAND_PARAMS);
    }

    /**
     * @param string $commandParams
     * @return CommandScheduleInterface
     */
    public function setCommandParams(string $commandParams): CommandScheduleInterface
    {
        return $this->setData(self::COMMAND_PARAMS, $commandParams);
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param string $status
     * @return CommandScheduleInterface
     */
    public function setStatus(string $status): CommandScheduleInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->getData(self::RESULT);
    }

    /**
     * @param string $result
     * @return CommandScheduleInterface
     */
    public function setResult(string $result): CommandScheduleInterface
    {
        return $this->setData(self::RESULT, $result);
    }

    /**
     * @return string|null
     */
    public function getScheduledAt(): ?string
    {
        return $this->getData(self::SCHEDULED_AT);
    }

    /**
     * @param string $scheduledAt
     * @return CommandScheduleInterface
     */
    public function setScheduledAt(string $scheduledAt): CommandScheduleInterface
    {
        return $this->setData(self::SCHEDULED_AT, $scheduledAt);
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return CommandScheduleInterface
     */
    public function setUpdatedAt(string $updatedAt): CommandScheduleInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    protected function _construct()
    {
        $this->_init(CommandScheduleResource::class);
    }
}
