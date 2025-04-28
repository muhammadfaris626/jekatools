<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mews\Captcha\Facades\Captcha;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $referral_code = '';
    public string $referred_by = '';
    public string $whatsapp_number = '';
    public string $captcha = '';
    public string $captcha_image = '';

    public function mount()
    {
        $this->captcha_image = captcha_img();
    }

    public function refreshCaptcha()
    {
        $this->captcha_image = captcha_img();
    }

    public function register(): void {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'whatsapp_number' => ['required'],
            'password' => ['required', 'min:8', 'string', Rules\Password::defaults()],
            'referral_code' => 'nullable|string|exists:users,referral_code',
            'referred_by' => 'nullable|string',
            'captcha' => 'required|captcha'
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'whatsapp_number.required' => 'Kolom nomor whatsapp wajib diisi.',
            'password.required' => 'Kolom kata sandi wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'email.unique' => 'Email sudah terdaftar, harap gunakan email yang berbeda.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
            'captcha.captcha' => 'Captcha tidak sesuai.',
            'captcha.required' => 'Captcha wajib diisi.'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $referrer = User::where('referral_code', $validated['referral_code'])->first();
        $validated['referral_code'] = Str::random(8);
        $validated['referred_by'] = $referrer?->referral_code;
        event(new Registered(($user = User::create($validated))));
        $user->assignRole('User');
        Auth::login($user);
        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Buat akun')" :description="__('Masukkan detail di bawah ini untuk membuat akun Anda')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
                <flux:input
                    wire:model="name"
                    :label="__('Nama')"
                    type="text"
                    autocomplete="name"
                    :placeholder="__('Nama lengkap')"
                />
            </div>
            <div>
                <flux:input
                    wire:model="email"
                    :label="__('Email')"
                    type="email"
                    autocomplete="email"
                    placeholder="email@example.com"
                />
            </div>
            <div>
                <flux:field>
                    <flux:label>{{ __('Nomor Whatsapp') }}</flux:label>
                    <flux:input.group>
                        <flux:input.group.prefix>+62</flux:input.group.prefix>
                        <flux:input wire:model="whatsapp_number" autocomplete="tel" placeholder="8xxxxxxxxxx" />
                    </flux:input.group>
                    <flux:error name="whatsapp_number" />
                </flux:field>
            </div>
            <div>
                <flux:input
                    wire:model="password"
                    :label="__('Kata sandi')"
                    type="password"
                    autocomplete="new-password"
                    :placeholder="__('Kata sandi')"
                />
            </div>
            <div>
                <flux:input
                    wire:model="referral_code"
                    :label="__('Kode referal (opsional)')"
                    type="text"
                    autocomplete="off"
                    :placeholder="__('Masukkan kode referal')"
                />
            </div>
            <div class="grid grid-cols-9 gap-2">
                <div class="col-span-9">
                    <flux:input
                        :label="__('Masukkan Captcha')"
                        wire:model.defer="captcha"
                        type="text"
                        placeholder="Masukkan hasil captcha dibawah"
                    />
                </div>
                <div class="col-span-8 border rounded-lg flex items-center justify-center shadow-xs dark:border-white/10 dark:bg-white/10 py-1">
                    <span>{!! captcha_img() !!}</span>
                </div>
                <div>
                    <flux:button wire:click="refreshCaptcha" icon="arrow-path" type="button" class="w-full"></flux:button>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Daftar') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Sudah punya akun?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Masuk') }}</flux:link>
    </div>
</div>
