<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Delete account') }}</h3>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <x-button color="red" x-on:click="$modalOpen('confirm-user-deletion')">
        {{ __('Delete account') }}
    </x-button>

    <x-modal id="confirm-user-deletion" title="{{ __('Are you sure you want to delete your account?') }}" x-on:close="$wire.reset('password')">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <x-password wire:model="password" label="{{ __('Password') }}" />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <x-button outline x-on:click="$modalClose('confirm-user-deletion')">{{ __('Cancel') }}</x-button>

                <x-button color="red" type="submit">{{ __('Delete account') }}</x-button>
            </div>
        </form>
    </x-modal>
</section>
