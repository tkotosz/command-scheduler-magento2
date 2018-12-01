<?php

namespace Tkotosz\CommandScheduler\Block\Adminhtml\Schedule\Create\From;

use Magento\Backend\Block\Widget\Tabs as BaseTabs;

class Tabs extends BaseTabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('command_schedule_create_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Command'));
    }
}
