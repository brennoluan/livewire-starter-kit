<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\PasskeyUser;

test('user model implements expected interfaces', function (): void {
    $user = new User();

    expect($user)->toBeInstanceOf(PasskeyUser::class)
        ->and($user)->toBeInstanceOf(MustVerifyEmail::class);
});

test('user initials calculation', function (): void {
    $user = new User(['name' => 'John Doe']);
    expect($user->initials())->toBe('JD');

    $singleNameUser = new User(['name' => 'Single']);
    expect($singleNameUser->initials())->toBe('S');

    $longNameUser = new User(['name' => 'Jane Mary Smith']);
    expect($longNameUser->initials())->toBe('JS');
});

test('user casts attributes correctly', function (): void {
    $user = User::factory()->create([
        'password' => 'secret-password',
    ]);

    expect($user->email_verified_at)->toBeInstanceOf(DateTimeInterface::class)
        ->and($user->password)->not->toBe('secret-password');
});
