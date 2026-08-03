<?php

declare(strict_types=1);

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Security;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Route::livewire('settings/profile', Profile::class)->name('profile.edit')->withHead(title: 'Profile settings');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::livewire('settings/appearance', Appearance::class)->name('appearance.edit')->withHead(title: 'Appearance settings');

    Route::livewire('settings/security', Security::class)
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit')
        ->withHead(title: 'Security settings');
});

Route::get('.well-known/passkey-endpoints', fn () => response()->json([
    'enroll' => route('security.edit'),
    'manage' => route('security.edit'),
]))->name('well-known.passkeys');
