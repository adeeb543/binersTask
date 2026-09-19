<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    // خدمة تسجيل مستخدم جديد
    public function register(array $data): array
    {
        // إنشاء المستخدم وتشفير كلمة المرور
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // توليد توكن الدخول عبر Sanctum
        $token = $user->createToken('user_auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    // خدمة تسجيل الدخول
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        // التحقق من وجود المستخدم وكلمة المرور
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['البيانات المدخلة غير مطابقة لسجلاتنا.'],
            ]);
        }

        // حذف التوكنات القديمة (اختياري للأمان) أو إنشاء توكن جديد
        $token = $user->createToken('user_auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user): void
{
    $user->currentAccessToken()->delete();
}

}
