<div>
    <x-button sm outline icon="pencil" wire:click="$set('modalState', true)">{{ __('Edit') }}</x-button>

    <x-modal id="edit-permission-{{ $permission->id }}" wire="modalState" title="{{ __('Edit Permission') }}" center x-on:close="$wire.resetFields()">
        <form wire:submit="updatePermission" class="space-y-4">
            <x-input wire:model="name" label="{{ __('Permission Name') }}" required />

            <div class="flex justify-end gap-2 pt-2">
                <x-button outline type="button" wire:click="$set('modalState', false)">{{ __('Cancel') }}</x-button>
                <x-button type="submit" icon="check" wire:loading.attr="disabled">{{ __('Save') }}</x-button>
            </div>
        </form>
    </x-modal>
</div>
