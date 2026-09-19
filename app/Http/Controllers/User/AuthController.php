<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'تم إنشاء الحساب بنجاح',
            'data' => $result['user'],
            'token' => $result['token'],
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => $result['user'],
            'token' => $result['token'],
        ], 200);
    }

    public function logout(Request $request)
{
    $this->authService->logout($request->user());

    return response()->json([
        'status' => true,
        'message' => 'تم تسجيل الخروج بنجاح',
    ], 200);
}
}
