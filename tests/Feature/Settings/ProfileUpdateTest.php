<?php

declare(strict_types=1);

use App\Livewire\Settings\Profile;
use App\Models\User;
use Livewire\Livewire;

test('profile page is displayed', function (): void {
    $this->actingAs($user = User::factory()->create());

    $this->get('/settings/profile')->assertOk();
});

test('profile information can be updated', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User')
        ->and($user->email)->toEqual('test@example.com')
        ->and($user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when email address is unchanged', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull()
        ->and(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});

test('verification notification can be resent', function (): void {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->call('resendVerificationNotification');

    $response->assertHasNoErrors();
});

test('resend verification notification redirects when email is already verified', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->call('resendVerificationNotification');

    $response->assertRedirect(route('dashboard', absolute: false));
});
