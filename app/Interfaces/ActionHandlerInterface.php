<?php

namespace App\Interfaces;

use App\Objects\ActionData;

interface ActionHandlerInterface
{
    public function execute(ActionData $actionData): void;
}
