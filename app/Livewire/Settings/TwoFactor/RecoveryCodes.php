<?php

declare(strict_types=1);

namespace App\Livewire\Settings\TwoFactor;

use App\Models\User;
use Exception;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class RecoveryCodes extends Component
{
    /** @var list<string> */
    #[Locked]
    public array $recoveryCodes = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->loadRecoveryCodes();
    }

    /**
     * Generate new recovery codes for the user.
     */
    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generateNewRecoveryCodes): void
    {
        /** @var User $user */
        $user = auth()->user();

        $generateNewRecoveryCodes($user);

        $this->loadRecoveryCodes();
    }

    /**
     * Load the recovery codes for the user.
     */
    private function loadRecoveryCodes(): void
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->hasEnabledTwoFactorAuthentication() && is_string($user->two_factor_recovery_codes)) {
            try {
                $decrypted = decrypt($user->two_factor_recovery_codes);

                if (is_string($decrypted)) {
                    $codes = json_decode($decrypted, true);

                    $this->recoveryCodes = is_array($codes) ? array_values(array_filter($codes, is_string(...))) : [];
                }
            } catch (Exception) {
                $this->addError('recoveryCodes', 'Failed to load recovery codes');

                $this->recoveryCodes = [];
            }
        }
    }
}
