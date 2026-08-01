<section class="w-full">
    @include('partials.settings-heading')

    <h2 class="sr-only">{{ __('Security settings') }}</h2>

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <x-password
                wire:model="current_password"
                label="{{ __('Current password') }}"
                required
                autocomplete="current-password"
            />
            <x-password
                wire:model="password"
                label="{{ __('New password') }}"
                required
                autocomplete="new-password"
            />
            <x-password
                wire:model="password_confirmation"
                label="{{ __('Confirm password') }}"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <x-button type="submit" data-test="update-password-button">{{ __('Save') }}</x-button>
            </div>
        </form>

        @if ($canManageTwoFactor)
            <section class="mt-12">
                <h3 class="text-lg font-semibold text-neutral-950 dark:text-white">{{ __('Two-factor authentication') }}</h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Manage your two-factor authentication settings') }}</p>

                <div class="flex flex-col w-full mx-auto mt-6 space-y-6 text-sm" wire:cloak>
                    @if ($twoFactorEnabled)
                        <div class="space-y-4">
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                {{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                            </p>

                            <div class="flex justify-start">
                                <x-button
                                    color="red"
                                    wire:click="disable"
                                >
                                    {{ __('Disable 2FA') }}
                                </x-button>
                            </div>

                            <livewire:settings.two-factor.recovery-codes :$requiresConfirmation />
                        </div>
                    @else
                        <div class="space-y-4">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                            </p>

                            <x-button
                                wire:click="enable"
                            >
                                {{ __('Enable 2FA') }}
                            </x-button>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        @if ($canManageTwoFactor)
            <x-modal
                id="two-factor-setup-modal"
                wire="showModal"
                x-on:close="$wire.closeModal()"
            >
                <div class="space-y-6">
                    <div class="flex flex-col items-center space-y-4">
                        <div class="w-auto rounded-full border border-neutral-200 bg-white p-0.5 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                            <div class="relative overflow-hidden rounded-full border border-neutral-200 bg-primary-50 p-2.5 dark:border-neutral-700 dark:bg-primary-950/40">
                                <div class="absolute inset-0 flex h-full w-full items-stretch justify-around divide-x divide-primary-200/60 opacity-50 [&>div]:flex-1 dark:divide-primary-800/60">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div></div>
                                    @endfor
                                </div>

                                <div class="absolute inset-0 flex h-full w-full flex-col items-stretch justify-around divide-y divide-primary-200/60 opacity-50 [&>div]:flex-1 dark:divide-primary-800/60">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div></div>
                                    @endfor
                                </div>

                                <x-icon name="qr-code" class="relative z-20 size-6 text-primary-700 dark:text-primary-300" />
                            </div>
                        </div>

                        <div class="space-y-2 text-center">
                            <h3 class="text-lg font-semibold text-neutral-950 dark:text-white">{{ $this->modalConfig['title'] }}</h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $this->modalConfig['description'] }}</p>
                        </div>
                    </div>

                    @if ($showVerificationStep)
                        <div class="space-y-6">
                            <div
                                class="flex flex-col items-center space-y-3 justify-center"
                                x-data
                                x-init="$nextTick(() => $el.querySelector('input')?.focus())"
                            >
                                <x-pin
                                    name="code"
                                    wire:model="code"
                                    length="6"
                                    class="mx-auto"
                                />
                            </div>

                            <div class="flex items-center space-x-3">
                                <x-button
                                    outline
                                    class="flex-1"
                                    wire:click="resetVerification"
                                >
                                    {{ __('Back') }}
                                </x-button>

                                <x-button
                                    class="flex-1"
                                    wire:click="confirmTwoFactor"
                                    x-bind:disabled="$wire.code.length < 6"
                                >
                                    {{ __('Confirm') }}
                                </x-button>
                            </div>
                        </div>
                    @else
                        @error('setupData')
                            <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/50 dark:text-red-300">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="flex justify-center">
                            <div class="relative aspect-square w-64 overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">
                                @empty($qrCodeSvg)
                                    <div class="absolute inset-0 flex animate-pulse items-center justify-center bg-white dark:bg-neutral-800">
                                        <x-icon name="arrow-path" class="size-6 animate-spin text-neutral-500" />
                                    </div>
                                @else
                                    <div class="flex h-full items-center justify-center p-4">
                                        <div class="rounded bg-white p-3">
                                            {!! $qrCodeSvg !!}
                                        </div>
                                    </div>
                                @endempty
                            </div>
                        </div>

                        <div>
                            <x-button
                                :disabled="$errors->has('setupData')"
                                class="w-full"
                                wire:click="showVerificationIfNecessary"
                            >
                                {{ $this->modalConfig['buttonText'] }}
                            </x-button>
                        </div>

                        <div class="space-y-4">
                            <div class="relative flex items-center justify-center w-full">
                                <div class="absolute inset-0 top-1/2 h-px w-full bg-neutral-200 dark:bg-neutral-700"></div>
                                <span class="relative bg-white px-2 text-sm text-neutral-600 dark:bg-neutral-900 dark:text-neutral-400">
                                    {{ __('or, enter the code manually') }}
                                </span>
                            </div>

                            <div
                                class="flex items-center space-x-2"
                                x-data="{
                                    copied: false,
                                    async copy() {
                                        try {
                                            await navigator.clipboard.writeText('{{ $manualSetupKey }}');
                                            this.copied = true;
                                            setTimeout(() => this.copied = false, 1500);
                                        } catch (e) {
                                            console.warn('Could not copy to clipboard');
                                        }
                                    }
                                }"
                            >
                                <div class="flex w-full items-stretch rounded-xl border border-neutral-200 dark:border-neutral-700">
                                    @empty($manualSetupKey)
                                        <div class="flex w-full items-center justify-center bg-neutral-100 p-3 dark:bg-neutral-800">
                                            <x-icon name="arrow-path" class="size-5 animate-spin text-neutral-500" />
                                        </div>
                                    @else
                                        <input
                                            type="text"
                                            readonly
                                            value="{{ $manualSetupKey }}"
                                            class="w-full bg-transparent p-3 text-neutral-900 outline-none dark:text-neutral-100"
                                        />

                                        <button
                                            @click="copy()"
                                            class="cursor-pointer border-l border-neutral-200 px-3 transition-colors dark:border-neutral-700"
                                        >
                                            <x-icon name="document-duplicate" x-show="!copied" class="size-5" />
                                            <x-icon name="check" x-show="copied" class="size-5 text-green-500" />
                                        </button>
                                    @endempty
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-modal>
        @endif

        @if ($canManagePasskeys)
            <section class="mt-12">
                <h3 class="text-lg font-semibold text-neutral-950 dark:text-white">{{ __('Passkeys') }}</h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Manage your passkeys for passwordless sign-in') }}</p>

                <div class="mt-6 flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                    <div class="overflow-hidden rounded-lg border border-neutral-200 bg-white/80 dark:border-neutral-800 dark:bg-neutral-900/60">
                        @forelse ($passkeys as $passkey)
                            <div class="flex items-center justify-between p-4 {{ ! $loop->last ? 'border-b border-neutral-200 dark:border-neutral-800' : '' }}">
                                <div class="flex items-center gap-4">
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 dark:bg-primary-950/40">
                                        <x-icon name="key" class="size-5 text-primary-700 dark:text-primary-300" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2.5">
                                            <p class="font-medium tracking-tight">{{ $passkey['name'] }}</p>
                                            @if ($passkey['authenticator'])
                                                <x-badge sm>{{ $passkey['authenticator'] }}</x-badge>
                                            @endif
                                        </div>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ __('Added :time', ['time' => $passkey['created_at_diff']]) }}
                                            @if ($passkey['last_used_at_diff'])
                                                <span class="opacity-50 mx-1">/</span>
                                                {{ __('Last used :time', ['time' => $passkey['last_used_at_diff']]) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <x-button
                                    outline
                                    sm
                                    icon="trash"
                                    color="red"
                                    wire:click="confirmDelete({{ $passkey['id'] }})"
                                />
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-primary-50 dark:bg-primary-950/40">
                                    <x-icon name="key" class="size-7 text-primary-600 dark:text-primary-300" />
                                </div>
                                <p class="font-medium">{{ __('No passkeys yet') }}</p>
                                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">{{ __('Add a passkey to sign in without a password') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <x-passkey-registration />
                </div>
            </section>
        @endif
    </x-settings.layout>

    <x-modal
        id="delete-passkey-modal"
        wire="showDeleteModal"
        x-on:close="$wire.closeDeleteModal()"
    >
        <div class="space-y-6">
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-neutral-950 dark:text-white">{{ __('Remove passkey') }}</h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $deletingPasskeyName]) }}
                </p>
            </div>

            <div class="flex gap-3 justify-end">
                <x-button
                    outline
                    wire:click="closeDeleteModal"
                >
                    {{ __('Cancel') }}
                </x-button>
                <x-button
                    color="red"
                    wire:click="deletePasskey"
                >
                    {{ __('Remove passkey') }}
                </x-button>
            </div>
        </div>
    </x-modal>
</section>
