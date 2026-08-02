<div>
    <x-button icon="plus" wire:click="$set('modalState', true)">{{ __('Create user') }}</x-button>

    <x-modal id="users-create" wire="modalState" title="{{ __('Create User') }}" center x-on:close="$wire.resetFields()">
        <form wire:submit="createUser" class="space-y-4">
            <x-input wire:model="name" label="{{ __('Name') }}" required />
            <x-input wire:model="email" label="{{ __('Email') }}" type="email" required />
            <x-password wire:model="password" label="{{ __('Password') }}" required />

            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">{{ __('Roles') }}</label>
                <div class="grid grid-cols-2 gap-2 border border-neutral-200 dark:border-neutral-800 rounded-lg p-3">
                    @foreach($allRoles as $role)
                        <x-checkbox wire:model="selectedRoles" value="{{ $role->name }}" label="{{ $role->name }}" id="create-role-{{ $role->id }}" />
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <x-button outline type="button" wire:click="$set('modalState', false)">{{ __('Cancel') }}</x-button>
                <x-button type="submit" icon="check" wire:loading.attr="disabled">{{ __('Create user') }}</x-button>
            </div>
        </form>
    </x-modal>
</div>
