<div class="w-full space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-100">{{ __('Roles') }}</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Manage system roles and permissions') }}</p>
        </div>
        @can('create', App\Models\Role::class)
            <div>
                <livewire:roles.create />
            </div>
        @endcan
    </div>

    <x-table :$headers
             :rows="$roles"
             :$sort
             :filter="['quantity' => 'quantity', 'search' => 'search']"
             striped
             paginate
             loading>
        <x-slot:empty>
            <div class="py-8 text-center text-neutral-500 dark:text-neutral-400">
                <x-icon name="document-magnifying-glass" class="mx-auto size-12 mb-2 text-neutral-400" />
                <p class="font-medium">{{ __('No roles found.') }}</p>
                <p class="text-sm text-neutral-400 mt-1">{{ __('Try adjusting your search filters or create a new role.') }}</p>
            </div>
        </x-slot:empty>

        @interact('column_permissions_count', $row)
            <div class="flex flex-wrap gap-1">
                @forelse($row->permissions as $permission)
                    <x-badge text="{{ $permission->name }}" color="gray" sm />
                @empty
                    <span class="text-xs text-neutral-400">—</span>
                @endforelse
            </div>
        @endinteract

        @interact('column_action', $row)
            <div class="flex items-center gap-2">
                @can('update', $row)
                    <livewire:roles.update :role="$row" :wire:key="'roles-update-'.$row->id" />
                @endcan
                @can('delete', $row)
                    <livewire:roles.delete :role="$row" :wire:key="'roles-delete-'.$row->id" />
                @endcan
            </div>
        @endinteract
    </x-table>
</div>
