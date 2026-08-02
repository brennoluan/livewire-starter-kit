<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Brain\Workflows\DeleteUserWorkflow;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

final class Delete extends Component
{
    use Interactions;

    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function confirmDelete(): void
    {
        $this->authorize('delete', $this->user);

        $this->dialog()
            ->question(__('Are you sure?'), __('Do you really want to delete user ":name"? This action cannot be undone.', ['name' => $this->user->name]))
            ->confirm(__('Delete'), 'deleteUser')
            ->cancel(__('Cancel'))
            ->send();
    }

    public function deleteUser(): void
    {
        $this->authorize('delete', $this->user);

        DeleteUserWorkflow::run([
            'user' => $this->user,
        ]);

        $this->toast()->success(__('User deleted successfully.'))->send();
        $this->dispatch('userDeleted');
    }

    public function render(): Factory|View
    {
        return view('livewire.users.delete');
    }
}
