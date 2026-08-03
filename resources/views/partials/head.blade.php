<meta charset="utf-8" />

@php(filled($title ?? null) ? \Laravel\Head\Facades\Head::title($title) : null)

@head

@fonts

<tallstackui:script />
@livewireStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])
