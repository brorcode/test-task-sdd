<?php

namespace App\Objects;

use Carbon\Carbon;

class ActionData
{
    private int $userId;
    private Carbon $dateFrom;
    private Carbon $dateTo;

    public function __construct(int $userId, Carbon $dateFrom, Carbon $dateTo)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDateFrom(): Carbon
    {
        return $this->dateFrom;
    }

    public function getDateTo(): Carbon
    {
        return $this->dateTo;
    }
}
