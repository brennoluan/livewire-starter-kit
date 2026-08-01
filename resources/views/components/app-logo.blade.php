@props([
    'sidebar' => false,
])

<a {{ $attributes->merge(['class' => 'flex items-center gap-2 focus:outline-none']) }}>
    <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-primary-600 text-white shadow-xs shadow-primary-950/10 dark:bg-primary-400 dark:text-neutral-950">
        <x-app-logo-icon class="size-5 fill-current" />
    </div>
    <div class="grid flex-1 text-start text-sm leading-tight">
        <span class="truncate font-semibold text-neutral-950 dark:text-white">{{ config('app.name', 'Laravel') }}</span>
    </div>
</a>
