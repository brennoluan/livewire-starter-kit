<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Brain\Workflows\DeleteRoleWorkflow;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Delete extends Component
{
    use Interactions;

    public Role $role;

    public function mount(Role $role): void
    {
        $this->role = $role;
    }

    public function confirmDelete(): void
    {
        $this->authorize('delete', $this->role);

        $this->dialog()
            ->question(__('Are you sure?'), __('Do you really want to delete role ":name"? This action cannot be undone.', ['name' => $this->role->name]))
            ->confirm(__('Delete'), 'deleteRole')
            ->cancel(__('Cancel'))
            ->send();
    }

    public function deleteRole(): void
    {
        $this->authorize('delete', $this->role);

        DeleteRoleWorkflow::run([
            'role' => $this->role,
        ]);

        $this->toast()->success(__('Role deleted successfully.'))->send();
        $this->dispatch('roleDeleted');
    }

    public function render(): Factory|View
    {
        return view('livewire.roles.delete');
    }
}
