<?php

namespace Tkotosz\CommandScheduler\Setup\Schema;

use Tkotosz\CommandScheduler\Ddl\CommandScheduleTable;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class CommandScheduleTableManager
{
    public function createTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('tkotosz_command_schedule'));

        $table
            ->addColumn(
                CommandScheduleTable::COLUMN_SCHEDULE_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )
            ->addColumn(
                CommandScheduleTable::COLUMN_COMMAND_NAME,
                Table::TYPE_TEXT, 256,
                ['nullable' => false],
                'Command Name'
            )
            ->addColumn(
                CommandScheduleTable::COLUMN_COMMAND_PARAMS,
                Table::TYPE_TEXT,
                null,
                ['nullable' => false], 
                'Command Params'
            )
            ->addColumn(
                CommandScheduleTable::COLUMN_STATUS,
                Table::TYPE_TEXT,
                256,
                ['nullable' => false],
                'Status'
            )
            ->addColumn(
                CommandScheduleTable::COLUMN_RESULT,
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Result'
            )
            ->addColumn(
                CommandScheduleTable::COLUMN_SCHEDULED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Scheduled At'
            )
            ->addColumn(
                CommandScheduleTable::COLUMN_UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )
        ;

        $setup->getConnection()->createTable($table);
    }
}
