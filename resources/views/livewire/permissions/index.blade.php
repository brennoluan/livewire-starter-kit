<div class="w-full space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-100">{{ __('Permissions') }}</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Manage system permissions') }}</p>
        </div>
        @can('create', App\Models\Permission::class)
            <div>
                <livewire:permissions.create />
            </div>
        @endcan
    </div>

    <x-table :$headers
             :rows="$permissions"
             :$sort
             :filter="['quantity' => 'quantity', 'search' => 'search']"
             striped
             paginate
             loading>
        <x-slot:empty>
            <div class="py-8 text-center text-neutral-500 dark:text-neutral-400">
                <x-icon name="document-magnifying-glass" class="mx-auto size-12 mb-2 text-neutral-400" />
                <p class="font-medium">{{ __('No permissions found.') }}</p>
                <p class="text-sm text-neutral-400 mt-1">{{ __('Try adjusting your search filters or create a new permission.') }}</p>
            </div>
        </x-slot:empty>

        @interact('column_guard_name', $row)
            <x-badge text="{{ $row->guard_name }}" color="gray" sm />
        @endinteract

        @interact('column_action', $row)
            <div class="flex items-center gap-2">
                @can('update', $row)
                    <livewire:permissions.update :permission="$row" :wire:key="'permissions-update-'.$row->id" />
                @endcan
                @can('delete', $row)
                    <livewire:permissions.delete :permission="$row" :wire:key="'permissions-delete-'.$row->id" />
                @endcan
            </div>
        @endinteract
    </x-table>
</div>
