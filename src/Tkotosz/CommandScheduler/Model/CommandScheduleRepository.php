<?php

namespace Tkotosz\CommandScheduler\Model;

use Exception;
use Tkotosz\CommandScheduler\Api\CommandScheduleRepositoryInterface;
use Tkotosz\CommandScheduler\Api\Data\CommandScheduleInterface;
use Tkotosz\CommandScheduler\Api\Data\CommandScheduleInterfaceFactory as CommandScheduleFactory;
use Tkotosz\CommandScheduler\Api\Data\CommandScheduleSearchResultsInterface;
use Tkotosz\CommandScheduler\Api\Data\CommandScheduleSearchResultsInterfaceFactory as CommandScheduleSearchResultsFactory;
use Tkotosz\CommandScheduler\Model\ResourceModel\CommandSchedule as CommandScheduleResource;
use Tkotosz\CommandScheduler\Model\ResourceModel\CommandSchedule\CollectionFactory as CommandScheduleCollectionFactory;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CommandScheduleRepository implements CommandScheduleRepositoryInterface
{
    /**
     * @var CommandScheduleFactory
     */
    private $commandScheduleFactory;
    
    /**
     * @var CommandScheduleResource
     */
    private $commandScheduleResource;
    
    /**
     * @var CommandScheduleCollectionFactory
     */
    private $commandScheduleCollectionFactory;
    
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    
    /**
     * @var CommandScheduleSearchResultsFactory
     */
    private $searchResultsFactory;
    
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    
    /**
     * @param CommandScheduleFactory              $commandScheduleFactory
     * @param CommandScheduleResource             $commandScheduleResource
     * @param CommandScheduleCollectionFactory    $commandScheduleCollectionFactory
     * @param CollectionProcessorInterface        $collectionProcessor
     * @param CommandScheduleSearchResultsFactory $searchResultsFactory
     * @param SearchCriteriaBuilder               $searchCriteriaBuilder
     */
    public function __construct(
        CommandScheduleFactory $commandScheduleFactory,
        CommandScheduleResource $commandScheduleResource,
        CommandScheduleCollectionFactory $commandScheduleCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        CommandScheduleSearchResultsFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->commandScheduleFactory = $commandScheduleFactory;
        $this->commandScheduleResource = $commandScheduleResource;
        $this->commandScheduleCollectionFactory = $commandScheduleCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function save(CommandScheduleInterface $commandSchedule): CommandScheduleInterface
    {
        try {
            $this->commandScheduleResource->save($commandSchedule);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the command schedule: %1', $e->getMessage()), $e);
        }

        return $commandSchedule;
    }

    public function create(string $commandName, string $commandParams): CommandScheduleInterface
    {
        $command = $this->commandScheduleFactory->create()
            ->setCommandName($commandName)
            ->setCommandParams($commandParams)
            ->setStatus('pending');

        return $this->save($command);
    }

    public function updateStatus(CommandScheduleInterface $commandSchedule, string $status): CommandScheduleInterface
    {
        return $this->save($commandSchedule->setStatus($status));
    }

    public function updateResult(CommandScheduleInterface $commandSchedule, string $result): CommandScheduleInterface
    {
        return $this->save($commandSchedule->setResult($result));
    }

    public function getById(int $id): CommandScheduleInterface
    {
        $commandSchedule = $this->commandScheduleFactory->create();

        $this->commandScheduleResource->load($commandSchedule, $id);
        
        if (!$commandSchedule->getId()) {
            throw new NoSuchEntityException(__("Command Schedule with id '%1' not found", $id));
        }

        return $commandSchedule;
    }

    public function getList(SearchCriteria $searchCriteria): CommandScheduleSearchResultsInterface
    {
        $collection = $this->commandScheduleCollectionFactory->create();
        
        $this->collectionProcessor->process($searchCriteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    public function getOneByStatus(string $status): ?CommandScheduleInterface
    {
        $schedule = $this->commandScheduleCollectionFactory->create()
            ->addFieldToFilter('status', $status)
            ->getFirstItem();

        return $schedule->getId() ? $schedule : null;
    }

    public function getAll(): CommandScheduleSearchResultsInterface
    {
        return $this->getList($this->searchCriteriaBuilder->create());
    }

    public function delete(CommandScheduleInterface $commandSchedule): bool
    {
        try {
            $this->commandScheduleResource->delete($commandSchedule);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete the command schedule: %1', $e->getMessage()));
        }

        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
