<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Brain\Workflows\UpdateUserProfileWorkflow;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Update extends Component
{
    use Interactions;

    public bool $modalState = false;

    public User $user;

    public string $name = '';

    public string $email = '';

    /** @var array<int, string> */
    public array $selectedRoles = [];

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        /** @var array<int, string> $roles */
        $roles = $user->roles->pluck('name')->toArray();
        $this->selectedRoles = $roles;
    }

    public function resetFields(): void
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        /** @var array<int, string> $roles */
        $roles = $this->user->roles->pluck('name')->toArray();
        $this->selectedRoles = $roles;
        $this->resetErrorBag();
    }

    public function updateUser(): void
    {
        $this->authorize('update', $this->user);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
            'selectedRoles' => ['nullable', 'array'],
        ]);

        UpdateUserProfileWorkflow::run([
            'user' => $this->user,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->selectedRoles,
        ]);

        $this->modalState = false;

        $this->toast()->success(__('User updated successfully.'))->send();
        $this->dispatch('userUpdated');
    }

    public function render(): Factory|View
    {
        $allRoles = Role::query()->orderBy('name')->get();

        return view('livewire.users.update', [
            'allRoles' => $allRoles,
        ]);
    }
}
