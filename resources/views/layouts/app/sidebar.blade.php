<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme({ default: 'system' })">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased transition-colors" x-bind:class="{ 'dark bg-neutral-950 text-neutral-100': darkTheme, 'bg-neutral-50 text-neutral-950': ! darkTheme }">
        <div class="flex min-h-screen flex-col lg:flex-row" x-data="{ sidebarOpen: false }">
            <!-- Mobile Navigation Bar -->
            <div class="flex items-center justify-between border-b border-neutral-200 bg-white/90 px-4 py-2.5 shadow-xs backdrop-blur dark:border-neutral-800 dark:bg-neutral-950/90 lg:hidden">
                <button @click="sidebarOpen = !sidebarOpen" type="button" class="rounded-md p-1.5 text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800 focus:outline-none">
                    <x-icon name="bars-3" class="size-6" />
                </button>

                <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

                <x-dropdown position="bottom-end">
                    <x-slot:action>
                        <button type="button" x-on:click="show = !show" class="flex items-center focus:outline-none">
                            <x-avatar text="{{ auth()->user()->initials() }}" sm />
                        </button>
                    </x-slot:action>
                    <div class="flex items-center gap-2 border-b border-neutral-200 px-3 py-2 text-start text-sm dark:border-neutral-800">
                        <x-avatar text="{{ auth()->user()->initials() }}" sm />
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold text-neutral-900 dark:text-white">{{ auth()->user()->name }}</span>
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
            </div>

            <!-- Sidebar Overlay (Mobile) -->
            <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-neutral-950/45 backdrop-blur-xs lg:hidden" x-cloak></div>

            <!-- Sidebar -->
            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-e border-neutral-200 bg-white/95 p-4 shadow-xl transition-transform duration-200 backdrop-blur dark:border-neutral-800 dark:bg-neutral-950/95 lg:static lg:translate-x-0 lg:shadow-none"
            >
                <div class="flex items-center justify-between pb-4">
                    <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                    <button @click="sidebarOpen = false" class="rounded-md p-1 text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-800 lg:hidden">
                        <x-icon name="x-mark" class="size-5" />
                    </button>
                </div>

                <nav class="flex flex-1 flex-col space-y-6 pt-2">
                    <div>
                        <div class="px-2 text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ __('Platform') }}
                        </div>
                        <div class="mt-2 space-y-1">
                            <a
                                href="{{ route('dashboard') }}"
                                wire:navigate
                                class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-800 dark:bg-primary-950/45 dark:text-primary-200' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white' }}"
                            >
                                <x-icon name="home" class="size-5" />
                                <span>{{ __('Dashboard') }}</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-auto space-y-1">
                        <a
                            href="https://github.com/laravel/livewire-starter-kit"
                            target="_blank"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white"
                        >
                            <x-icon name="code-bracket" class="size-5" />
                            <span>{{ __('Repository') }}</span>
                        </a>
                        <a
                            href="https://laravel.com/docs/starter-kits#livewire"
                            target="_blank"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 hover:text-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white"
                        >
                            <x-icon name="book-open" class="size-5" />
                            <span>{{ __('Documentation') }}</span>
                        </a>
                    </div>
                </nav>

                <div class="mt-4 hidden border-t border-neutral-200 pt-4 dark:border-neutral-800 lg:block">
                    <x-desktop-user-menu />
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>

        <x-toast />
        @livewireScripts
    </body>
</html>
