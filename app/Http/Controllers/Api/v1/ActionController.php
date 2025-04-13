<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActionRequest;
use App\Objects\ActionData;
use App\Services\ActionHandlerFactory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ActionController extends Controller
{
    public function run(ActionRequest $request, ActionHandlerFactory $factory): JsonResponse
    {
        $handler = $factory->make($request->getActionType());
        $handler->execute(new ActionData(
            $request->user_id,
            $request->getDateFrom(),
            $request->getDateTo(),
        ));

        return response()->json(
            ['message' => 'Action processing initiated successfully.'],
            Response::HTTP_ACCEPTED,
        );
    }
}
