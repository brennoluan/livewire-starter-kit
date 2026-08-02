<?php

declare(strict_types=1);

use App\Livewire\Permissions\Index as PermissionsIndex;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('users', UsersIndex::class)->name('users.index');
    Route::livewire('roles', RolesIndex::class)->name('roles.index');
    Route::livewire('permissions', PermissionsIndex::class)->name('permissions.index');
});

require __DIR__.'/settings.php';
