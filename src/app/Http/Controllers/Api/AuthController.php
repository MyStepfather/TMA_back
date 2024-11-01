<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $user = User::firstOrCreate(
            ['username' => $username],
            []
        );

        return response()->json($user);
    }
}
