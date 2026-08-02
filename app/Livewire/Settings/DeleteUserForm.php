<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Brain\Workflows\DeleteUserWorkflow;
use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class DeleteUserForm extends Component
{
    use PasswordValidationRules;

    public string $password = '';

    public function resetFields(): void
    {
        $this->reset('password');
        $this->resetErrorBag();
    }

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        /** @var User $user */
        $user = Auth::user();

        $logout();

        DeleteUserWorkflow::run([
            'user' => $user,
        ]);

        $this->redirect('/', navigate: true);
    }
}
