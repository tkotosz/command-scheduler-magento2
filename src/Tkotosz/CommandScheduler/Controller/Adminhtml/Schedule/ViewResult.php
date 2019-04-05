<?php

namespace Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\ResponseInterface;
use Tkotosz\CommandScheduler\Api\CommandScheduleRepositoryInterface;
use Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;

class ViewResult extends Schedule
{
    /**
     * Execute action based on request and return result
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        /** @var Http $response */
        $response = $this->getResponse();
        $repo = ObjectManager::getInstance()->get(CommandScheduleRepositoryInterface::class);

        $thing = $repo->getById($this->getRequest()->getParam('id'));

        $response->setBody(nl2br($thing->getResult()));

        return $this->getResponse();
    }
}

