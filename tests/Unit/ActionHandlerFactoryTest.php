<?php

namespace Tests\Unit;

use App\Enums\ActionType;
use App\Services\ActionHandlerFactory;
use App\Services\DataImportHandler;
use Illuminate\Support\Facades\App;
use LogicException;
use ReflectionClass;
use stdClass;
use Tests\TestCase;

class ActionHandlerFactoryTest extends TestCase
{
    private ActionHandlerFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ActionHandlerFactory();
    }

    public function testMakeThrowsExceptionForNonExistentHandlerClass(): void
    {
        $reflection = new ReflectionClass($this->factory);
        $handlerMapProperty = $reflection->getProperty('handlerMap');

        $originalHandlerMap = $handlerMapProperty->getValue($this->factory);

        $modifiedHandlerMap = $originalHandlerMap;
        $modifiedHandlerMap[ActionType::ACTION_TYPE_DATA_IMPORT->value] = 'NonExistentHandlerClass';
        $handlerMapProperty->setValue($this->factory, $modifiedHandlerMap);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("No handler defined for action type: " . ActionType::ACTION_TYPE_DATA_IMPORT->value);

        $this->factory->make(ActionType::ACTION_TYPE_DATA_IMPORT);

        $handlerMapProperty->setValue($this->factory, $originalHandlerMap);
    }

    public function testMakeThrowsExceptionForHandlerNotImplementingInterface(): void
    {
        $mockHandler = $this->mock(stdClass::class);

        App::shouldReceive('make')
            ->once()
            ->with(DataImportHandler::class)
            ->andReturn($mockHandler)
        ;

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Handler class " . DataImportHandler::class . " must implement ActionHandlerInterface.");

        $this->factory->make(ActionType::ACTION_TYPE_DATA_IMPORT);
    }
}
