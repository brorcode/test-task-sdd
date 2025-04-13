<?php

namespace App\Services;

use App\Interfaces\ActionHandlerInterface;
use App\Jobs\DataBackupJob;
use App\Objects\ActionData;

class DataBackupHandler implements ActionHandlerInterface
{
    public function execute(ActionData $actionData): void
    {
        DataBackupJob::dispatch($actionData);
    }
}
