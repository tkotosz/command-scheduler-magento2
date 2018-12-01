<?php

namespace Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;

use Tkotosz\CommandScheduler\Controller\Adminhtml\Schedule;
use Tkotosz\CommandScheduler\Request\Factory\CreateCommandScheduleRequestFactory;
use Tkotosz\CommandScheduler\Request\Processor\CreateCommandScheduleRequestProcessor;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Psr\Log\LoggerInterface;

class Save extends Schedule
{
    const SUCCESS_PATH = 'tkotosz_commandscheduler/schedule/index';
    const ERROR_PATH = 'tkotosz_commandscheduler/schedule/create';

    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * @var CreateCommandScheduleRequestFactory
     */
    private $requestFactory;
    
    /**
     * @var CreateCommandScheduleRequestProcessor
     */
    private $requestProcessor;

    /**
     * @param Context                               $context
     * @param LoggerInterface                       $logger
     * @param CreateCommandScheduleRequestFactory   $requestFactory
     * @param CreateCommandScheduleRequestProcessor $requestProcessor
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        CreateCommandScheduleRequestFactory $requestFactory,
        CreateCommandScheduleRequestProcessor $requestProcessor
    ) {
        parent::__construct($context);

        $this->logger = $logger;
        $this->requestFactory = $requestFactory;
        $this->requestProcessor = $requestProcessor;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface
     */
    public function execute()
    {
        try {
            $request = $this->requestFactory->createFromHttpRequest($this->getRequest());
            $this->requestProcessor->process($request);
            $this->messageManager->addSuccessMessage('Command scheduled.');
            $path = self::SUCCESS_PATH;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->_getSession()->setScheduleFormData($this->getRequest()->getParams());
            $this->messageManager->addErrorMessage('An error occurred whilst scheduling the command: ' . $e->getMessage());
            $path = self::ERROR_PATH;
        }

        return $this->resultRedirectFactory->create()->setPath($path);
    }
}
