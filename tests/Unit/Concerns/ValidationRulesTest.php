<?php

declare(strict_types=1);

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;

final class TestValidationRulesContainer
{
    use PasswordValidationRules;
    use ProfileValidationRules;

    public function getPasswordRules(): array
    {
        return $this->passwordRules();
    }

    public function getCurrentPasswordRules(): array
    {
        return $this->currentPasswordRules();
    }

    public function getProfileRules(?int $userId = null): array
    {
        return $this->profileRules($userId);
    }
}

test('password validation rules trait provides correct rules', function (): void {
    $container = new TestValidationRulesContainer();

    $passwordRules = $container->getPasswordRules();
    expect($passwordRules)->toBeArray()
        ->and($passwordRules)->toContain('required', 'string', 'confirmed');

    $currentPasswordRules = $container->getCurrentPasswordRules();
    expect($currentPasswordRules)->toBeArray()
        ->and($currentPasswordRules)->toContain('required', 'string', 'current_password');
});

test('profile validation rules trait provides correct rules', function (): void {
    $container = new TestValidationRulesContainer();

    $rulesWithoutId = $container->getProfileRules();
    expect($rulesWithoutId)->toHaveKeys(['name', 'email']);

    $rulesWithId = $container->getProfileRules(123);
    expect($rulesWithId)->toHaveKeys(['name', 'email']);
});
