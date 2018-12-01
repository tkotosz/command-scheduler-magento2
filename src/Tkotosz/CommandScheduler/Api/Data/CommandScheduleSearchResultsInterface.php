<?php

namespace Tkotosz\CommandScheduler\Api\Data;

use Tkotosz\CommandScheduler\Api\Data\CommandScheduleInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface CommandScheduleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get brands list.
     *
     * @return CommandScheduleInterface[]
     */
    public function getItems(): array;

    /**
     * Set brands list.
     *
     * @param CommandScheduleInterface[] $items
     * 
     * @return $this
     */
    public function setItems(array $items): CommandScheduleSearchResultsInterface;
}
