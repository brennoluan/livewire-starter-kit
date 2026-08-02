<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Brain\Workflows\UpdateRoleWorkflow;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Update extends Component
{
    use Interactions;

    public bool $modalState = false;

    public Role $role;

    public string $name = '';

    /** @var array<int, string> */
    public array $selectedPermissions = [];

    public function mount(Role $role): void
    {
        $this->role = $role;
        $this->name = $role->name;
        /** @var array<int, string> $permissions */
        $permissions = $role->permissions->pluck('name')->toArray();
        $this->selectedPermissions = $permissions;
    }

    public function resetFields(): void
    {
        $this->name = $this->role->name;
        /** @var array<int, string> $permissions */
        $permissions = $this->role->permissions->pluck('name')->toArray();
        $this->selectedPermissions = $permissions;
        $this->resetErrorBag();
    }

    public function updateRole(): void
    {
        $this->authorize('update', $this->role);

        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->role->id)],
            'selectedPermissions' => ['nullable', 'array'],
        ]);

        UpdateRoleWorkflow::run([
            'role' => $this->role,
            'name' => $this->name,
            'permissions' => $this->selectedPermissions,
        ]);

        $this->modalState = false;

        $this->toast()->success(__('Role updated successfully.'))->send();
        $this->dispatch('roleUpdated');
    }

    public function render(): Factory|View
    {
        $allPermissions = Permission::query()->orderBy('name')->get();

        return view('livewire.roles.update', [
            'allPermissions' => $allPermissions,
        ]);
    }
}
