@props([
    'status',
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-primary-700 dark:text-primary-300']) }}>
        {{ $status }}
    </div>
@endif
