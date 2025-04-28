<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';
    public string $captcha = '';
    public string $captcha_image = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */

    public function refreshCaptcha()
    {
        $this->captcha_image = captcha_img();
    }

    public function login(): void
    {
        $this->validate([
            'email' => 'required|string|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ], [
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'password.required' => 'Kolom kata sandi wajib diisi.',
            'captcha.captcha' => 'Captcha tidak sesuai.',
            'captcha.required' => 'Captcha wajib diisi.'
        ]);

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Masuk ke akun Anda')"
        :description="__('Masukkan email dan kata sandi Anda untuk masuk')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
            <div class="col-span-1 sm:col-span-2 sm:col-start-2">
                <flux:input
                    wire:model="email"
                    :label="__('Email')"
                    type="email"
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />
            </div>

            <div class="col-span-1 sm:col-span-2 sm:col-start-2">
                <div class="relative">
                    <flux:input
                        wire:model="password"
                        :label="__('Kata sandi')"
                        type="password"
                        autocomplete="current-password"
                        :placeholder="__('Kata sandi')"
                    />
                    @if (Route::has('password.request'))
                        <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                            {{ __('Lupa kata sandi Anda?') }}
                        </flux:link>
                    @endif
                </div>
            </div>
            <div class="col-span-1 sm:col-span-2 sm:col-start-2">
                <div class="grid grid-cols-6 gap-2">
                    <div class="col-span-6">
                        <flux:input
                            :label="__('Masukkan Captcha')"
                            wire:model.defer="captcha"
                            type="text"
                            placeholder="Masukkan hasil captcha dibawah"
                        />
                    </div>
                    <div class="col-span-5 border rounded-lg flex items-center justify-center shadow-xs dark:border-white/10 dark:bg-white/10 py-1">
                        <span>{!! captcha_img() !!}</span>
                    </div>
                    <div>
                        <flux:button wire:click="refreshCaptcha" icon="arrow-path" type="button" class="w-full"></flux:button>
                    </div>
                </div>
            </div>

            <div class="col-span-1 sm:col-span-2 sm:col-start-2">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <flux:checkbox wire:model.defer="remember" :label="__('Ingat saya')" />
                    </div>
                    <div class="flex justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Masuk') }}</flux:button>
                    </div>
                    <div>
                        @if (Route::has('register'))
                            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                                {{ __('Belum punya akun?') }}
                                <flux:link :href="route('register')" wire:navigate>{{ __('Daftar') }}</flux:link>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
