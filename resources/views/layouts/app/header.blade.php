<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme({ default: 'system' })">
    <head>
        @include('partials.head')
    </head>
    <body class="h-screen w-screen overflow-hidden flex flex-col antialiased transition-colors" x-bind:class="{ 'dark bg-neutral-950 text-neutral-100': darkTheme, 'bg-neutral-50 text-neutral-950': ! darkTheme }">
        <header class="sticky top-0 z-40 shrink-0 border-b border-neutral-200 bg-white/90 shadow-xs backdrop-blur dark:border-neutral-800 dark:bg-neutral-950/90" x-data="{ mobileOpen: false }">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="rounded-md p-1.5 text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800 lg:hidden">
                        <x-icon name="bars-3" class="size-6" />
                    </button>
                    <x-app-logo href="{{ route('dashboard') }}" wire:navigate />
                    <nav class="hidden lg:flex lg:items-center lg:gap-4 ml-6">
                        <a
                            href="{{ route('dashboard') }}"
                            wire:navigate
                            class="flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-800 dark:bg-primary-950/45 dark:text-primary-200' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white' }}"
                        >
                            <x-icon name="squares-2x2" class="size-4" />
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="hidden sm:flex items-center gap-1.5 text-sm text-neutral-600 hover:text-neutral-950 dark:text-neutral-400 dark:hover:text-white">
                        <x-icon name="code-bracket" class="size-5" />
                        <span>{{ __('Repository') }}</span>
                    </a>
                    <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="hidden sm:flex items-center gap-1.5 text-sm text-neutral-600 hover:text-neutral-950 dark:text-neutral-400 dark:hover:text-white">
                        <x-icon name="book-open" class="size-5" />
                        <span>{{ __('Documentation') }}</span>
                    </a>
                    <x-desktop-user-menu />
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto mx-auto w-full max-w-7xl p-4 sm:p-6">
            {{ $slot }}
        </main>

        <x-toast />
        <x-dialog />
        @livewireScripts
    </body>
</html>
