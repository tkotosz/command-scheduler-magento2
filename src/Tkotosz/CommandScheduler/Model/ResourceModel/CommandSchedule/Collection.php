<?php

namespace Tkotosz\CommandScheduler\Model\ResourceModel\CommandSchedule;

use Tkotosz\CommandScheduler\Model\CommandSchedule as CommandScheduleModel;
use Tkotosz\CommandScheduler\Model\ResourceModel\CommandSchedule as CommandScheduleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(CommandScheduleModel::class, CommandScheduleResource::class);
    }
}
