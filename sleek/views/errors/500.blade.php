<x-app-layout>
    <x-slot name="title">
        {{ __('errors.500.title') }}
    </x-slot>

    <div class="min-h-[calc(100vh-12rem)] flex items-center justify-center px-6 py-24">
        <div class="max-w-xl w-full space-y-8 text-center">
            <div
                class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-warning/20 bg-warning/10 text-warning">
                <x-ri-alert-line class="size-5" />
                <span class="text-sm font-semibold tracking-wide">500</span>
            </div>

            <div class="space-y-4">
                <h1 class="text-4xl sm:text-5xl font-bold text-base">{{ __('errors.500.title') }}</h1>
                <p class="text-base/70 text-lg">{{ __('errors.500.message') }}</p>
            </div>

            <div class="bg-background-secondary border border-neutral/20 rounded-2xl shadow-sm p-8 space-y-6">
                <div class="flex justify-center">
                    <div class="bg-warning/10 border border-warning/20 rounded-2xl p-4">
                        <x-ri-tools-line class="size-8 text-warning" />
                    </div>
                </div>

                <p class="text-base/60 text-sm">{{ __('errors.500.message') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
