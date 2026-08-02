<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Roles')]
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

    #[On('roleCreated')]
    #[On('roleUpdated')]
    #[On('roleDeleted')]
    public function refresh(): void
    {
        // Triggers re-render on CRUD events
    }

    public function render(): Factory|View
    {
        $this->authorize('viewAny', Role::class);

        $headers = [
            ['index' => 'name', 'label' => __('Role Name')],
            ['index' => 'permissions_count', 'label' => __('Permissions'), 'sortable' => false],
            ['index' => 'action', 'label' => __('Actions'), 'sortable' => false],
        ];

        /** @var 'asc'|'desc' $direction */
        $direction = mb_strtolower($this->sort['direction']) === 'desc' ? 'desc' : 'asc';

        $roles = Role::query()
            ->with('permissions')
            ->when($this->search, fn (Builder $query): Builder => $query->where('name', 'like', sprintf('%%%s%%', $this->search)))
            ->orderBy($this->sort['column'], $direction)
            ->paginate($this->quantity);

        return view('livewire.roles.index', [
            'headers' => $headers,
            'roles' => $roles,
        ]);
    }
}
