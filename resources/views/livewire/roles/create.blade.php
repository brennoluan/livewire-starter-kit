<div>
    <x-button icon="plus" wire:click="$set('modalState', true)">{{ __('Create role') }}</x-button>

    <x-modal id="roles-create" wire="modalState" title="{{ __('Create Role') }}" center x-on:close="$wire.resetFields()">
        <form wire:submit="createRole" class="space-y-4">
            <x-input wire:model="name" label="{{ __('Role Name') }}" required />

            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">{{ __('Permissions') }}</label>
                <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto border border-neutral-200 dark:border-neutral-800 rounded-lg p-3">
                    @foreach($allPermissions as $permission)
                        <x-checkbox wire:model="selectedPermissions" value="{{ $permission->name }}" label="{{ $permission->name }}" id="create-permission-{{ $permission->id }}" />
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <x-button outline type="button" wire:click="$set('modalState', false)">{{ __('Cancel') }}</x-button>
                <x-button type="submit" icon="check" wire:loading.attr="disabled">{{ __('Create role') }}</x-button>
            </div>
        </form>
    </x-modal>
</div>
