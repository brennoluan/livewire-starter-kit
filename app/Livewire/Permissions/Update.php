<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Brain\Workflows\UpdatePermissionWorkflow;
use App\Models\Permission;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Update extends Component
{
    use Interactions;

    public bool $modalState = false;

    public Permission $permission;

    public string $name = '';

    public function mount(Permission $permission): void
    {
        $this->permission = $permission;
        $this->name = $permission->name;
    }

    public function resetFields(): void
    {
        $this->name = $this->permission->name;
        $this->resetErrorBag();
    }

    public function updatePermission(): void
    {
        $this->authorize('update', $this->permission);

        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($this->permission->id)],
        ]);

        UpdatePermissionWorkflow::run([
            'permission' => $this->permission,
            'name' => $this->name,
        ]);

        $this->modalState = false;

        $this->toast()->success(__('Permission updated successfully.'))->send();
        $this->dispatch('permissionUpdated');
    }

    public function render(): Factory|View
    {
        return view('livewire.permissions.update');
    }
}
