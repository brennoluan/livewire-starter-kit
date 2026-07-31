<?php

declare(strict_types=1);

use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

test('logout action logs user out and redirects', function (): void {
    $user = User::factory()->create();
    Auth::login($user);

    expect(Auth::check())->toBeTrue();

    $logout = new Logout();
    $response = $logout();

    expect(Auth::check())->toBeFalse()
        ->and($response)->toBeInstanceOf(RedirectResponse::class);
});
