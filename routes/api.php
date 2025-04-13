<?php

use App\Http\Controllers\Api\v1\ActionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::group(['prefix' => 'actions', 'as' => 'actions.'], function () {
        Route::post('/run', [ActionController::class, 'run'])->name('run');
    });
});
