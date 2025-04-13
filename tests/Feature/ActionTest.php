<?php

namespace Tests\Feature;

use App\Enums\ActionType;
use App\Jobs\DataBackupJob;
use App\Jobs\DataCleanupJob;
use App\Jobs\DataImportJob;
use App\Models\User;
use App\Services\DataImportHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    #[DataProvider('validActionTypesProvider')]
    public function testActionCanBeRun(ActionType $actionType, string $jobClass): void
    {
        Queue::fake();

        $response = $this->postJson(route('api.v1.actions.run'), [
            'type_id' => $actionType->value,
            'user_id' => $this->user->getKey(),
            'date_from' => '2023-01-01',
            'date_to' => '2023-01-31',
        ]);

        Queue::assertPushed($jobClass);

        $response->assertAccepted();
    }

    #[DataProvider('invalidRequestProvider')]
    public function testActionCanNotBeRunWithInvalidRequestData(array $request, array $errors): void
    {
        $response = $this->postJson(route('api.v1.actions.run'), $request);

        $response->assertUnprocessable();
        $response->assertOnlyJsonValidationErrors($errors);
    }

    public function testActionCanReturnErrorWhenHandlerThrowsException(): void
    {
        $this->mock(DataImportHandler::class, function ($mock) {
            $mock->shouldReceive('execute')->andThrow(new LogicException('Some error'));
        });

        $response = $this->postJson(route('api.v1.actions.run'), [
            'type_id' => ActionType::ACTION_TYPE_DATA_IMPORT->value,
            'user_id' => $this->user->getKey(),
            'date_from' => '2023-01-01',
            'date_to' => '2023-01-31',
        ]);

        $response->assertInternalServerError();
        $response->assertJson(['message' => 'Something went wrong.']);
    }

    public static function validActionTypesProvider(): array
    {
        return [
            'data_import_action' => [
                'actionType' => ActionType::ACTION_TYPE_DATA_IMPORT,
                'jobClass' => DataImportJob::class,
            ],
            'data_cleanup_action' => [
                'actionType' => ActionType::ACTION_TYPE_DATA_CLEANUP,
                'jobClass' => DataCleanupJob::class,
            ],
            'data_backup_action' => [
                'actionType' => ActionType::ACTION_TYPE_DATA_BACKUP,
                'jobClass' => DataBackupJob::class,
            ],
        ];
    }

    public static function invalidRequestProvider(): array
    {
        return [
            'invalid_data_1' => [
                'request' => [],
                'errors' => ['type_id', 'user_id', 'date_from', 'date_to'],
            ],
            'invalid_data_2' => [
                'request' => [
                    'type_id' => 'invalid',
                    'user_id' => 'invalid',
                    'date_from' => 'invalid',
                    'date_to' => 'invalid',
                ],
                'errors' => ['type_id', 'user_id', 'date_from', 'date_to'],
            ],
            'invalid_data_3' => [
                'request' => [
                    'type_id' => 'invalid',
                    'user_id' => 'invalid',
                    'date_from' => '2023-01-01',
                    'date_to' => '2023-01-01',
                ],
                'errors' => ['type_id', 'user_id', 'date_to'],
            ],
        ];
    }
}
