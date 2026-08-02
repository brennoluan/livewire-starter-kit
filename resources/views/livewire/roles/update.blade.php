<div>
    <x-button sm outline icon="pencil" wire:click="$set('modalState', true)">{{ __('Edit') }}</x-button>

    <x-modal id="edit-role-{{ $role->id }}" wire="modalState" title="{{ __('Edit Role') }}" center x-on:close="$wire.resetFields()">
        <form wire:submit="updateRole" class="space-y-4">
            <x-input wire:model="name" label="{{ __('Role Name') }}" required />

            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">{{ __('Permissions') }}</label>
                <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto border border-neutral-200 dark:border-neutral-800 rounded-lg p-3">
                    @foreach($allPermissions as $permission)
                        <x-checkbox wire:model="selectedPermissions" value="{{ $permission->name }}" label="{{ $permission->name }}" id="update-role-{{ $role->id }}-permission-{{ $permission->id }}" />
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
