<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Brain\Workflows\DeletePermissionWorkflow;
use App\Models\Permission;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Delete extends Component
{
    use Interactions;

    public Permission $permission;

    public function mount(Permission $permission): void
    {
        $this->permission = $permission;
    }

    public function confirmDelete(): void
    {
        $this->authorize('delete', $this->permission);

        $this->dialog()
            ->question(__('Are you sure?'), __('Do you really want to delete permission ":name"? This action cannot be undone.', ['name' => $this->permission->name]))
            ->confirm(__('Delete'), 'deletePermission')
            ->cancel(__('Cancel'))
            ->send();
    }

    public function deletePermission(): void
    {
        $this->authorize('delete', $this->permission);

        DeletePermissionWorkflow::run([
            'permission' => $this->permission,
        ]);

        $this->toast()->success(__('Permission deleted successfully.'))->send();
        $this->dispatch('permissionDeleted');
    }

    public function render(): Factory|View
    {
        return view('livewire.permissions.delete');
    }
}
