<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Brain\Workflows\CreateRoleWorkflow;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Create extends Component
{
    use Interactions;

    public bool $modalState = false;

    #[Validate(['required', 'string', 'max:255', 'unique:roles,name'])]
    public string $name = '';

    /** @var array<int, string> */
    public array $selectedPermissions = [];

    public function resetFields(): void
    {
        $this->reset(['name', 'selectedPermissions', 'modalState']);
        $this->resetErrorBag();
    }

    public function createRole(): void
    {
        $this->authorize('create', Role::class);

        $this->validate();

        CreateRoleWorkflow::run([
            'name' => $this->name,
            'permissions' => $this->selectedPermissions,
        ]);

        $this->resetFields();
        $this->modalState = false;

        $this->toast()->success(__('Role created successfully.'))->send();
        $this->dispatch('roleCreated');
    }

    public function render(): Factory|View
    {
        $allPermissions = Permission::query()->orderBy('name')->get();

        return view('livewire.roles.create', [
            'allPermissions' => $allPermissions,
        ]);
    }
}
