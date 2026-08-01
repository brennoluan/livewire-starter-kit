<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme({ default: 'system' })">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased transition-colors" x-bind:class="{ 'dark bg-neutral-950 text-neutral-100': darkTheme, 'bg-neutral-50 text-neutral-950': ! darkTheme }">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-primary-700 dark:text-primary-300" />
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="flex flex-col gap-6">
                    <div class="rounded-xl border border-neutral-200 bg-white/95 text-neutral-900 shadow-sm dark:border-neutral-800 dark:bg-neutral-900/90 dark:text-neutral-100">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>

        <x-toast />
        @livewireScripts
    </body>
</html>
