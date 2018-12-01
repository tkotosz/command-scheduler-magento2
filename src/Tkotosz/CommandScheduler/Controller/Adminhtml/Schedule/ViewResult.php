<?php

namespace Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;

class ViewResult extends Schedule
{
    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Tkotosz_CommandScheduler::manage_schedules');
        $resultPage->getConfig()->getTitle()->prepend(__('Scheduled Commands'));

        $repo = \Magento\Framework\App\ObjectManager::getInstance()->get(\Tkotosz\CommandScheduler\Api\CommandScheduleRepositoryInterface::class);

        $thing = $repo->getById($this->getRequest()->getParam('id'));

        echo $thing->getResult();

        die;

        return $resultPage;
    }
}
