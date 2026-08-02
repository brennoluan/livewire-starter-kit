<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Models\Permission;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permissions')]
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

    #[On('permissionCreated')]
    #[On('permissionUpdated')]
    #[On('permissionDeleted')]
    public function refresh(): void
    {
        // Triggers re-render on CRUD events
    }

    public function render(): Factory|View
    {
        $this->authorize('viewAny', Permission::class);

        $headers = [
            ['index' => 'name', 'label' => __('Permission Name')],
            ['index' => 'guard_name', 'label' => __('Guard')],
            ['index' => 'action', 'label' => __('Actions'), 'sortable' => false],
        ];

        /** @var 'asc'|'desc' $direction */
        $direction = mb_strtolower($this->sort['direction']) === 'desc' ? 'desc' : 'asc';

        $permissions = Permission::query()
            ->when($this->search, fn (Builder $query): Builder => $query->where('name', 'like', sprintf('%%%s%%', $this->search)))
            ->orderBy($this->sort['column'], $direction)
            ->paginate($this->quantity);

        return view('livewire.permissions.index', [
            'headers' => $headers,
            'permissions' => $permissions,
        ]);
    }
}
