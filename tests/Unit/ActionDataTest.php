<?php

namespace Tests\Unit;

use App\Objects\ActionData;
use Tests\TestCase;

class ActionDataTest extends TestCase
{
    public function testActionDataCanBeCreatedAndAccessed(): void
    {
        $actionData = new ActionData(
            $userId = 1,
            $dateFrom = now()->subMonth(),
            $dateTo = now(),
        );

        $this->assertEquals($userId, $actionData->getUserId());
        $this->assertEquals($dateFrom, $actionData->getDateFrom());
        $this->assertEquals($dateTo, $actionData->getDateTo());
    }
}
