<?php

namespace App\Http\Requests\Auth;

use App\Models\Player;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('nama') && $this->filled('name')) {
            $this->merge(['nama' => $this->input('name')]);
        }

        $this->merge(['nama' => trim((string) $this->input('nama'))]);
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): Player
    {
        $this->ensureIsNotRateLimited();

        $player = Player::with('user')
            ->whereRaw('LOWER(nama) = LOWER(?)', [(string) $this->input('nama')])
            ->first();

        if (! $player || ! $player->user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nama' => 'Nama tidak ditemukan.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        return $player;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nama' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('nama')).'|'.$this->ip());
    }
}
