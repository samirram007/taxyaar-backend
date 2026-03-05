<?php

namespace App\Modules\Auth\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Contracts\AuthServiceInterface;
use App\Modules\Auth\Requests\ChangePasswordRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;

use App\Modules\User\Contracts\UserServiceInterface;
use App\Modules\User\Resources\UserResource;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    protected $domain;
    protected $token_expire_duration;
    public function __construct(
        protected AuthServiceInterface $authService,
        protected UserServiceInterface $userService
    ) {
        // dd(config('session.domain'));
        $this->domain = config('session.domain');

        $this->token_expire_duration = config('session.lifetime') * 60; // Convert minutes to seconds
    }
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={ "email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@admin.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User Login successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXV0aC9sb2dpbiIsImlhdCI6MTY4NjQ2NjQwNSwiZXhwIjoxNjg2NDY2NDY1LCJuYmYiOjE2ODY0NjY0MDUsImp0aSI6IjZqZ0NlQ052Zk1nN294QyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Qq1540d3x-2410q4aH29S7d7oWq8J34730j4"),
     *                 @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         )
     *     ),
     * )
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());
        return $this->respondWithToken($token, 'Login successful!');

    }

    public function googleLogin(\Illuminate\Http\Request $request): JsonResponse
    {
        try {
            $token = $request->input('access_token');
            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Token required'], 400);
            }

            $googleData = $this->decodeGoogleToken($token);
            if (!$googleData) {
                return response()->json(['status' => 'error', 'message' => 'Invalid token'], 401);
            }

            // Check if user exists by provider ID
            $user = $this->userService->findByProvider('google', $googleData['sub']);

            // If NOT exists, create new user
            if (!$user) {
                $user = $this->userService->store([
                    'name' => $googleData['name'] ?? '',
                    'email' => $googleData['email'],
                    'username' => str_replace('@', '_', $googleData['email']),
                    'provider' => 'google',
                    'provider_id' => $googleData['sub'],
                    'user_type' => 'user',
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            $jwtToken = $this->authService->loginWithUser($user);
            
            $cookie = cookie(
                'token',
                $jwtToken,
                $this->token_expire_duration,
                '/',
                $this->domain,
                true,
                true,
                true,
                'None'
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Google login successful!',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                    'status' => $user->status,
                ]
            ])->withCookie($cookie);
        } catch (\Exception $e) {
            Log::error('Google login: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Authentication failed'], 401);
        }
    }

    //rn using manual decoding not socialite(will work later on)
    private function decodeGoogleToken(string $token): ?array
    {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 3) return null;

            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            return isset($payload['sub'], $payload['email']) ? $payload : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function socialCallback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = $this->userService->findOrCreateFromProvider($socialUser, $provider);

        $token = $this->authService->loginWithUser($user); // ← uses same method!

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request): JsonResponse
    {

        $token = $this->authService->register($request->validated());
        return $this->respondWithToken($token, 'User created successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged out successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         )
     *     ),
     * )
     */

    public function logout(): JsonResponse
    {

        $this->authService->logout();
        $cookie = cookie('token', '', -1, '/', $this->domain, true, true);

        return response()->json(['message' => 'Logged out'])->withCookie($cookie);
    }
    public function clean_logout(): JsonResponse
    {

        // $this->authService->logout();
        $cookie = cookie('token', '', -1, '/', $this->domain, true, true);

        return response()->json(['message' => 'Logged out'])->withCookie($cookie);
    }



    public function profile(): JsonResponse
    {

        $user = $this->authService->profile();
        return response()->json([
            'status' => 'success',
            'message' => 'User profile fetched successfully.',
            'data' => new UserResource($user),
        ]);
    }
    public function profile2(): JsonResponse
    {

        // $user = $this->authService->profile();
        return response()->json([
            'status' => 'success',
            'message' => 'User profile fetched successfully.',
            'data' => [],
        ]);
    }
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->authService->changePassword($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.',
            'data' => [],
        ]);
    }



    public function refresh()
    {
        $token = $this->authService->refresh();
        return $this->respondWithToken($token, 'Token refreshed successfully!');

    }


    public function testGoogleLogin(): JsonResponse
    {
        try {
            $googleData = [
                'sub' => '123456789',
                'name' => 'Test User',
                'email' => 'testuser@gmail.com'
            ];

            $user = $this->userService->findByProvider('google', $googleData['sub']);
            if (!$user) {
                $user = $this->userService->store([
                    'name' => $googleData['name'],
                    'email' => $googleData['email'],
                    'provider' => 'google',
                    'provider_id' => $googleData['sub'],
                    'user_type' => 'user',
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            $token = $this->authService->loginWithUser($user);
            return $this->respondWithToken($token, 'Test Google login successful!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 400
            ], 400);
        }
    }

    protected function respondWithToken(string $token, string $message = 'Authenticated successfully!')
    {
        // Log::info(
        //     'AuthService initialized response',
        //     ['domain' => $this->domain, 'token_expire_duration' => $this->token_expire_duration, 'token' => $token]
        // );
        $cookie = cookie(
            'token',
            $token,
            $this->token_expire_duration,
            '/',
            $this->domain,
            true,
            true,
            true,
            'None'
        );
        Log::info(' cookie', ['cookie' => $cookie]);

        return response()->json([
            // 'token' => $token,
            'status' => 'success',
            'message' => $message,
        ])->withCookie($cookie);
    }
}
