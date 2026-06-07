<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginIdentifier = $this->input('email');

        // Cek apakah input berupa NIP atau NUPTK guru di database
        $guru = \App\Models\Guru::where('nip', $loginIdentifier)
            ->orWhere('nuptk', $loginIdentifier)
            ->first();

        if ($guru) {
            if ($guru->user) {
                // Jika sudah punya akun, gunakan email akun tersebut untuk otentikasi
                $loginIdentifier = $guru->user->email;
            } else {
                // Jika data guru ada tapi belum memiliki akun user, daftarkan otomatis
                $email = ($guru->nip ?? $guru->nuptk ?? $guru->id) . '@emoneva.com';
                
                // Cari apakah email kebetulan sudah terdaftar di users
                $existingUser = \App\Models\User::where('email', $email)->first();
                if (!$existingUser) {
                    $user = \App\Models\User::create([
                        'name' => $guru->nama,
                        'email' => $email,
                        'phone' => $guru->telepon,
                        'role' => 5, // Role Guru
                        'sekolah_id' => $guru->sekolah_id,
                        'guru_id' => $guru->id,
                        'password' => Hash::make($this->input('password')), // Password yang diketik akan didaftarkan
                    ]);
                    $loginIdentifier = $email;
                } else {
                    $loginIdentifier = $existingUser->email;
                }
            }
        } else {
            // Jika guru belum terdaftar di database, dan input bukan email (tidak mengandung @) serta panjang > 8 (menghindari NPSN)
            if (!str_contains($loginIdentifier, '@') && strlen($loginIdentifier) > 8) {
                throw ValidationException::withMessages([
                    'email' => 'NIP/NUPTK Anda belum didaftarkan oleh Operator Sekolah. Silakan hubungi Operator Sekolah Anda.',
                ]);
            }
        }

        if (! Auth::attempt(['email' => $loginIdentifier, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
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
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
