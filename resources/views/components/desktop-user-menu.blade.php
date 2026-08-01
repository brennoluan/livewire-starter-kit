<x-dropdown position="bottom-start" {{ $attributes }}>
    <x-slot:action>
        <button type="button" x-on:click="show = !show" class="flex w-full items-center gap-2 rounded-lg p-2 text-start text-sm hover:bg-neutral-100 dark:hover:bg-neutral-800 focus:outline-none" data-test="sidebar-menu-button">
            <x-avatar text="{{ auth()->user()->initials() }}" sm />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <span class="truncate font-semibold text-neutral-950 dark:text-white">{{ auth()->user()->name }}</span>
                <span class="truncate text-xs text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</span>
            </div>
            <x-icon name="chevron-up-down" class="size-4 text-neutral-500" />
        </button>
    </x-slot:action>

    <div class="flex items-center gap-2 border-b border-neutral-200 px-3 py-2 text-start text-sm dark:border-neutral-800">
        <x-avatar text="{{ auth()->user()->initials() }}" sm />
        <div class="grid flex-1 text-start text-sm leading-tight">
            <span class="truncate font-semibold text-neutral-950 dark:text-white">{{ auth()->user()->name }}</span>
            <span class="truncate text-xs text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</span>
        </div>
    </div>

    <x-dropdown.items text="{{ __('Settings') }}" icon="cog-6-tooth" :href="route('profile.edit')" wire:navigate />

    <form method="POST" action="{{ route('logout') }}" class="w-full">
        @csrf
        <button type="submit" class="flex w-full cursor-pointer items-center gap-2 px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800" data-test="logout-button">
            <x-icon name="arrow-right-start-on-rectangle" class="size-4" />
            <span>{{ __('Log out') }}</span>
        </button>
    </form>
</x-dropdown>
