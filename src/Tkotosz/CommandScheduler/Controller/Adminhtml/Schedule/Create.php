<?php

namespace Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;

use Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;

class Create extends Schedule
{
    /**
     * @var Registry
     */
    private $coreRegistry;
    
    /**
     * @param Registry $coreRegistry
     */
    public function __construct(Context $context, Registry $coreRegistry)
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
    }
    
    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $this->coreRegistry->register('tkotosz_command_scheduler_data_container', new DataObject($this->getRequest()->getParams()));

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Tkotosz_CommandScheduler::manage_schedules');
        $resultPage->getConfig()->getTitle()->prepend(__('Schedule Command'));

        return $resultPage;
    }
}
