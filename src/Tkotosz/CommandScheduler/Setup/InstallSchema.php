<?php

namespace Tkotosz\CommandScheduler\Setup;

use Tkotosz\CommandScheduler\Setup\Schema\CommandScheduleTableManager;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var CommandScheduleTableManager
     */
    private $commandScheduleTableManager;
    
    /**
     * @param CommandScheduleTableManager $commandScheduleTableManager
     */
    public function __construct(CommandScheduleTableManager $commandScheduleTableManager)
    {
        $this->commandScheduleTableManager = $commandScheduleTableManager;
    }
    
    /**
     * Installs the market module database schema
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->commandScheduleTableManager->createTable($setup);

        $setup->endSetup();
    }
}