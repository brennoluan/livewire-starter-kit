<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Brain\Workflows\CreateUserWorkflow;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Create extends Component
{
    use Interactions;

    public bool $modalState = false;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'string', 'email', 'max:255', 'unique:users,email'])]
    public string $email = '';

    #[Validate(['required', 'string', 'min:8'])]
    public string $password = '';

    /** @var array<int, string> */
    public array $selectedRoles = [];

    public function resetFields(): void
    {
        $this->reset(['name', 'email', 'password', 'selectedRoles', 'modalState']);
        $this->resetErrorBag();
    }

    public function createUser(): void
    {
        $this->authorize('create', User::class);

        $this->validate();

        CreateUserWorkflow::run([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
            'roles' => $this->selectedRoles,
        ]);

        $this->resetFields();
        $this->modalState = false;

        $this->toast()->success(__('User created successfully.'))->send();
        $this->dispatch('userCreated');
    }

    public function render(): Factory|View
    {
        $roles = Role::query()->orderBy('name')->get();

        return view('livewire.users.create', [
            'allRoles' => $roles,
        ]);
    }
}
