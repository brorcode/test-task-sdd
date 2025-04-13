<?php

namespace App\Services;

use App\Interfaces\ActionHandlerInterface;
use App\Jobs\DataImportJob;
use App\Objects\ActionData;

class DataImportHandler implements ActionHandlerInterface
{
    public function execute(ActionData $actionData): void
    {
        DataImportJob::dispatch($actionData);
    }
}
