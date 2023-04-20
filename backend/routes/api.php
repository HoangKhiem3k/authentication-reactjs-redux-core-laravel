<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CampaignController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/delete-refresh-token', [UserController::class, 'deleteRefreshToken']);
Route::post('/refresh-token', [UserController::class, 'refreshToken']);

Route::group(['middleware' => ['jwtauth', 'api']], function ($routes) {
  // auth routes
  Route::post('/profile-update', [UserController::class, 'updateProfile']);
  Route::post('/logout', [UserController::class, 'logout']);
  Route::get('/profile', [UserController::class, 'profile']);
  Route::get('/send-verify-mail/{email}', [UserController::class, 'sendVerifyMail']);
  Route::get('/verify-mail/{token}', [UserController::class, 'verificationMail']);
  // campaigns routes
  Route::post('/create-campaign', [CampaignController::class, 'createCampaign']);
  Route::get('/get-campaign-by-id', [CampaignController::class, 'getCampaignById']);
  Route::post('/update-campaign', [CampaignController::class, 'updateCampaign']);
  Route::post('/soft-delete-campaign', [CampaignController::class, 'softDeleteCampaign']);
  Route::delete('/delete-campaign', [CampaignController::class, 'deleteCampaign']);
  Route::get('/get-campaigns-search', [CampaignController::class, 'getCampaignsSearchPagination']);
});
Route::get('/campaigns/export', [CampaignController::class, 'export']);

Route::group(['middleware' => ['jwtauth', 'admin', 'api']], function ($routes) {
  Route::post('/create-account', [AccountController::class, 'createAccount']);
  Route::get('/get-account-by-id', [AccountController::class, 'getAccountById']);
  Route::post('/update-account', [AccountController::class, 'updateAccount']);
  Route::post('/soft-delete-account', [AccountController::class, 'softDeleteAccount']);
  Route::delete('/delete-account', [AccountController::class, 'deleteAccount']);
  Route::get('/get-account-search', [AccountController::class, 'getAccountsSearchPagination']);
});



