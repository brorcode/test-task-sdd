<?php

namespace App\Services;

use App\Enums\ActionType;
use App\Interfaces\ActionHandlerInterface;
use Illuminate\Support\Facades\App;
use LogicException;

class ActionHandlerFactory
{
    private array $handlerMap = [
        ActionType::ACTION_TYPE_DATA_IMPORT->value => DataImportHandler::class,
        ActionType::ACTION_TYPE_DATA_CLEANUP->value => DataCleanupHandler::class,
        ActionType::ACTION_TYPE_DATA_BACKUP->value => DataBackupHandler::class,
    ];

    public function make(ActionType $actionType): ActionHandlerInterface
    {
        $handlerClass = $this->handlerMap[$actionType->value] ?? null;

        if (!$handlerClass || !class_exists($handlerClass)) {
            throw new LogicException("No handler defined for action type: {$actionType->value}");
        }

        $handler = App::make($handlerClass);

        if (!($handler instanceof ActionHandlerInterface)) {
            throw new LogicException("Handler class {$handlerClass} must implement ActionHandlerInterface.");
        }

        return $handler;
    }
}
