<?php

namespace Tkotosz\CommandScheduler\Ui\DataProvider\Schedule;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tkotosz\CommandScheduler\Model\ResourceModel\CommandSchedule\CollectionFactory;

class ScheduleDataProvider extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
