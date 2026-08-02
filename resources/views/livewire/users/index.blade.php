<div class="w-full space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-100">{{ __('Users') }}</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('List, create, update and delete users') }}</p>
        </div>
        @can('create', App\Models\User::class)
            <div>
                <livewire:users.create />
            </div>
        @endcan
    </div>

    <x-table :$headers
             :rows="$users"
             :$sort
             :filter="['quantity' => 'quantity', 'search' => 'search']"
             striped
             paginate
             loading>
        <x-slot:empty>
            <div class="py-8 text-center text-neutral-500 dark:text-neutral-400">
                <x-icon name="document-magnifying-glass" class="mx-auto size-12 mb-2 text-neutral-400" />
                <p class="font-medium">{{ __('No users found.') }}</p>
                <p class="text-sm text-neutral-400 mt-1">{{ __('Try adjusting your search filters or create a new user.') }}</p>
            </div>
        </x-slot:empty>

        @interact('column_roles_list', $row)
            <div class="flex flex-wrap gap-1">
                @forelse($row->roles as $role)
                    <x-badge text="{{ $role->name }}" color="gray" sm />
                @empty
                    <span class="text-xs text-neutral-400">—</span>
                @endforelse
            </div>
        @endinteract

        @interact('column_action', $row)
            <div class="flex items-center gap-2">
                @can('update', $row)
                    <livewire:users.update :user="$row" :wire:key="'users-update-'.$row->id" />
                @endcan
                @can('delete', $row)
                    <livewire:users.delete :user="$row" :wire:key="'users-delete-'.$row->id" />
                @endcan
            </div>
        @endinteract
    </x-table>
</div>
