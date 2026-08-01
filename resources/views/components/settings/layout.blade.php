<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav aria-label="{{ __('Settings') }}" class="flex flex-col space-y-1">
            <a href="{{ route('profile.edit') }}" wire:navigate class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('profile.edit') ? 'bg-primary-50 text-primary-800 dark:bg-primary-950/45 dark:text-primary-200' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white' }}">{{ __('Profile') }}</a>
            <a href="{{ route('security.edit') }}" wire:navigate class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('security.edit') ? 'bg-primary-50 text-primary-800 dark:bg-primary-950/45 dark:text-primary-200' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white' }}">{{ __('Security') }}</a>
            <a href="{{ route('appearance.edit') }}" wire:navigate class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('appearance.edit') ? 'bg-primary-50 text-primary-800 dark:bg-primary-950/45 dark:text-primary-200' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white' }}">{{ __('Appearance') }}</a>
        </nav>
    </div>

    <div class="my-4 w-full border-b border-neutral-200 dark:border-neutral-800 md:hidden"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        <h2 class="text-lg font-semibold text-neutral-950 dark:text-white">{{ $heading ?? '' }}</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $subheading ?? '' }}</p>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
