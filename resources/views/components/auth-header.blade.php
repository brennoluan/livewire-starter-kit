@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-xl font-semibold text-neutral-950 dark:text-white">{{ $title }}</h1>
    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $description }}</p>
</div>
