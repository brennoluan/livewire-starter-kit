<?php

declare(strict_types=1);

use App\Livewire\Permissions\Index as PermissionsIndex;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home')->withHead(title: 'Welcome');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('dashboard', 'dashboard')->name('dashboard')->withHead(title: 'Dashboard');
    Route::livewire('users', UsersIndex::class)->name('users.index')->withHead(title: 'Users');
    Route::livewire('roles', RolesIndex::class)->name('roles.index')->withHead(title: 'Roles');
    Route::livewire('permissions', PermissionsIndex::class)->name('permissions.index')->withHead(title: 'Permissions');
});

require __DIR__.'/settings.php';
