<?php

namespace App\Jobs;

use App\Objects\ActionData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use LogicException;

class DataCleanupJob implements ShouldQueue
{
    use Queueable;

    private ActionData $actionData;

    public function __construct(ActionData $data)
    {
        $this->actionData = $data;
    }

    public function handle(): void
    {
        throw new LogicException('Not implemented');
    }
}
