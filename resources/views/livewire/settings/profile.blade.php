<section class="w-full">
    @include('partials.settings-heading')

    <h2 class="sr-only">{{ __('Profile settings') }}</h2>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <x-input wire:model="name" label="{{ __('Name') }}" type="text" required autofocus autocomplete="name" />

            <div>
                <x-input wire:model="email" label="{{ __('Email') }}" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div class="mt-4 text-sm text-zinc-600 dark:text-zinc-400">
                        <p>
                            {{ __('Your email address is unverified.') }}

                            <button type="button" class="font-medium text-zinc-900 underline hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300 cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <x-button type="submit">{{ __('Save') }}</x-button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
