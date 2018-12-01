<?php

namespace Tkotosz\CommandScheduler\Model\ResourceModel;

use Tkotosz\CommandScheduler\Ddl\CommandScheduleTable;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CommandSchedule extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(CommandScheduleTable::TABLE_NAME, CommandScheduleTable::COLUMN_SCHEDULE_ID);
    }
}
