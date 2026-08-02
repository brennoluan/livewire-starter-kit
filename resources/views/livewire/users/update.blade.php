<div>
    <x-button sm outline icon="pencil" wire:click="$set('modalState', true)">{{ __('Edit') }}</x-button>

    <x-modal id="edit-user-{{ $user->id }}" wire="modalState" title="{{ __('Edit User') }}" center x-on:close="$wire.resetFields()">
        <form wire:submit="updateUser" class="space-y-4">
            <x-input wire:model="name" label="{{ __('Name') }}" type="text" required />
            <x-input wire:model="email" label="{{ __('Email') }}" type="email" required />

            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">{{ __('Roles') }}</label>
                <div class="grid grid-cols-2 gap-2 border border-neutral-200 dark:border-neutral-800 rounded-lg p-3">
                    @foreach($allRoles as $role)
                        <x-checkbox wire:model="selectedRoles" value="{{ $role->name }}" label="{{ $role->name }}" id="update-user-{{ $user->id }}-role-{{ $role->id }}" />
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <x-button outline type="button" wire:click="$set('modalState', false)">{{ __('Cancel') }}</x-button>
                <x-button type="submit" icon="check" wire:loading.attr="disabled">{{ __('Save') }}</x-button>
            </div>
        </form>
    </x-modal>
</div>
