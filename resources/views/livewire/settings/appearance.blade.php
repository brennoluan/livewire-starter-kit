<section class="w-full">
    @include('partials.settings-heading')

    <h2 class="sr-only">{{ __('Appearance settings') }}</h2>

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <div class="inline-flex rounded-lg border border-neutral-200 bg-white p-1 shadow-xs dark:border-neutral-800 dark:bg-neutral-900">
            <x-theme-switch />
        </div>
    </x-settings.layout>
</section>
