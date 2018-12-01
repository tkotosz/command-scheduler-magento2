<?php

namespace Tkotosz\CommandScheduler\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class Schedule extends Action
{
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Tkotosz_CommandScheduler::manage');
    }
}
