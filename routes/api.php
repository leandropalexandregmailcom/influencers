<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\CampaignInfluencerController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::apiResource('influencers', InfluencerController::class);
    Route::apiResource('campaigns', CampaignController::class);
    Route::post('campaigns/{campaign_id}/influencers', [CampaignInfluencerController::class, 'attachInfluencer']);
    Route::get('campaigns/{id}/influencers', [CampaignInfluencerController::class, 'showCampaignInfluencers']);
});

