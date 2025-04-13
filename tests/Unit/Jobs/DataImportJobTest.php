<?php

namespace Tests\Unit\Jobs;

use App\Jobs\DataImportJob;
use App\Objects\ActionData;
use LogicException;
use Tests\TestCase;

class DataImportJobTest extends TestCase
{
    public function testDataBackupJobThrowsException(): void
    {
        /** @var ActionData $actionData */
        $actionData = $this->mock(ActionData::class);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not implemented');

        (new DataImportJob($actionData))->handle();
    }
}
