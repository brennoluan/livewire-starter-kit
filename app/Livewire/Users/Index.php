<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Users')]
final class Index extends Component
{
    use WithPagination;

    /** @var array{column: string, direction: string} */
    public array $sort = ['column' => 'name', 'direction' => 'asc'];

    public int $quantity = 10;

    public ?string $search = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedQuantity(): void
    {
        $this->resetPage();
    }

    #[On('userCreated')]
    #[On('userUpdated')]
    #[On('userDeleted')]
    public function refresh(): void
    {
        // Triggers component re-render on CRUD events
    }

    public function render(): Factory|View
    {
        $this->authorize('viewAny', User::class);

        $headers = [
            ['index' => 'name', 'label' => __('Name')],
            ['index' => 'email', 'label' => __('Email')],
            ['index' => 'roles_list', 'label' => __('Roles'), 'sortable' => false],
            ['index' => 'action', 'label' => __('Actions'), 'sortable' => false],
        ];

        /** @var 'asc'|'desc' $direction */
        $direction = mb_strtolower($this->sort['direction']) === 'desc' ? 'desc' : 'asc';

        $users = User::query()
            ->with('roles')
            ->when($this->search, fn (Builder $query): Builder => $query->where(fn (Builder $sub): Builder => $sub->where('name', 'like', sprintf('%%%s%%', $this->search))->orWhere('email', 'like', sprintf('%%%s%%', $this->search))))
            ->orderBy($this->sort['column'], $direction)
            ->paginate($this->quantity);

        return view('livewire.users.index', [
            'headers' => $headers,
            'users' => $users,
        ]);
    }
}
