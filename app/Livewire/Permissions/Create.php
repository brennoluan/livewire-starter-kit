<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Brain\Workflows\CreatePermissionWorkflow;
use App\Models\Permission;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Create extends Component
{
    use Interactions;

    public bool $modalState = false;

    #[Validate(['required', 'string', 'max:255', 'unique:permissions,name'])]
    public string $name = '';

    public function resetFields(): void
    {
        $this->reset(['name', 'modalState']);
        $this->resetErrorBag();
    }

    public function createPermission(): void
    {
        $this->authorize('create', Permission::class);

        $this->validate();

        CreatePermissionWorkflow::run([
            'name' => $this->name,
        ]);

        $this->resetFields();
        $this->modalState = false;

        $this->toast()->success(__('Permission created successfully.'))->send();
        $this->dispatch('permissionCreated');
    }

    public function render(): Factory|View
    {
        return view('livewire.permissions.create');
    }
}
