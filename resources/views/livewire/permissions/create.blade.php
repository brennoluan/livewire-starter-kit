<div>
    <x-button icon="plus" wire:click="$set('modalState', true)">{{ __('Create permission') }}</x-button>

    <x-modal id="permissions-create" wire="modalState" title="{{ __('Create Permission') }}" center x-on:close="$wire.resetFields()">
        <form wire:submit="createPermission" class="space-y-4">
            <x-input wire:model="name" label="{{ __('Permission Name') }}" required />

            <div class="flex justify-end gap-2 pt-2">
                <x-button outline type="button" wire:click="$set('modalState', false)">{{ __('Cancel') }}</x-button>
                <x-button type="submit" icon="check" wire:loading.attr="disabled">{{ __('Create permission') }}</x-button>
            </div>
        </form>
    </x-modal>
</div>
