<?php

namespace App\Services;

use App\Interfaces\ActionHandlerInterface;
use App\Jobs\DataCleanupJob;
use App\Objects\ActionData;

class DataCleanupHandler implements ActionHandlerInterface
{
    public function execute(ActionData $actionData): void
    {
        DataCleanupJob::dispatch($actionData);
    }
}
