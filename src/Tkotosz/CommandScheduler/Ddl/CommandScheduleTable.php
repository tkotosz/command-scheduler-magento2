<?php

namespace Tkotosz\CommandScheduler\Ddl;

class CommandScheduleTable
{
    public const TABLE_NAME = 'tkotosz_command_schedule';
    public const COLUMN_SCHEDULE_ID = 'schedule_id';
    public const COLUMN_COMMAND_NAME = 'command_name';
    public const COLUMN_COMMAND_PARAMS = 'command_params';
    public const COLUMN_STATUS = 'status';
    public const COLUMN_RESULT = 'result';
    public const COLUMN_SCHEDULED_AT = 'scheduled_at';
    public const COLUMN_UPDATED_AT = 'updated_at';
}
