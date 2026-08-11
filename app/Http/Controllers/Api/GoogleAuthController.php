<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoogleAuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class GoogleAuthController extends Controller
{
    public function __invoke(GoogleAuthRequest $request): JsonResponse
    {
        $idToken = $request->validated()['id_token'];

        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Google token',
            ], 401);
        }

        $payload = $response->json();

        if (!isset($payload['sub'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token payload',
            ], 401);
        }

        $user = User::where('google_id', $payload['sub'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $payload['name'] ?? $payload['email'] ?? 'Player',
                'email' => $payload['email'] ?? "{$payload['sub']}@google.user",
                'google_id' => $payload['sub'],
                'google_email' => $payload['email'] ?? null,
                'google_avatar' => $payload['picture'] ?? null,
            ]);
        } else {
            $user->update([
                'google_email' => $payload['email'] ?? $user->google_email,
                'google_avatar' => $payload['picture'] ?? $user->google_avatar,
                'name' => $payload['name'] ?? $user->name,
            ]);
        }

        $token = $user->createToken('construct3')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->google_email,
                    'avatar' => $user->google_avatar,
                ],
            ],
        ]);
    }
}
