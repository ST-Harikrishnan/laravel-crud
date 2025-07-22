<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\UserApiController;

Route::get('/post', [PostApiController::class, 'index']);

Route::get('/user', [UserApiController::class, 'show']);