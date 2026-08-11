<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $query = http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => url('/auth/google/callback'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/auth?' . $query);
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            abort(401, 'Google login dibatalkan atau gagal.');
        }

        $state = $request->session()->pull('google_oauth_state');
        if (!$state || !hash_equals($state, (string) $request->input('state'))) {
            abort(400, 'Invalid state.');
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $request->input('code'),
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => url('/auth/google/callback'),
            'grant_type' => 'authorization_code',
        ]);

        if ($tokenResponse->failed()) {
            abort(401, 'Gagal tukar kode OAuth.');
        }

        $accessToken = $tokenResponse->json('access_token');

        $userResponse = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($userResponse->failed()) {
            abort(401, 'Gagal mengambil data user.');
        }

        $payload = $userResponse->json();

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

        return redirect('/auth/google/success?token=' . $token);
    }

    public function success(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Login Google berhasil.',
            'data' => [
                'token' => $request->query('token'),
            ],
        ]);
    }
}
