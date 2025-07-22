<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
class UserApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working',
            'data' => User::all()
        ]);
    }
    public function show(User $user)
{
    return UserResource::collection(User::all());
}
}
