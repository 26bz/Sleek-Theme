<div class="pt-4">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-base">
                {{ __('Welcome back') }}, {{ Auth::user()->first_name }}
            </h1>
            <p class="text-base/60 mt-2">{{ __('Manage your services and account from your dashboard') }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if (!config('settings.tickets_disabled', false))
                <a href="{{ route('tickets.create') }}" wire:navigate>
                    <x-button.primary
                        class="flex items-center gap-2 py-2.5 px-4 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20">
                        <x-ri-add-line class="size-4" />
                        {{ __('New Ticket') }}
                    </x-button.primary>
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-background-secondary border border-neutral/20 rounded-lg p-6 hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 size-14 rounded-lg bg-neutral/10 flex items-center justify-center">
                    <x-ri-server-line class="size-7 text-base/80" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-base mb-1">
                        {{ Auth::user()->services()->where('status', 'active')->count() }}</h3>
                    <p class="text-sm font-medium text-base/70">{{ __('dashboard.active_services') }}</p>
                </div>
            </div>
        </div>

        @if (!config('settings.tickets_disabled', false))
            <div
                class="bg-background-secondary border border-neutral/20 rounded-lg p-6 hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 size-14 rounded-lg bg-neutral/10 flex items-center justify-center">
                        <x-ri-customer-service-line class="size-7 text-base/80" />
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-base mb-1">
                            {{ Auth::user()->tickets()->where('status', '!=', 'closed')->count() }}</h3>
                        <p class="text-sm font-medium text-base/70">{{ __('dashboard.open_tickets') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="bg-background-secondary border border-neutral/20 rounded-lg p-6 hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 size-14 rounded-lg bg-neutral/10 flex items-center justify-center">
                    <x-ri-bill-line class="size-7 text-base/80" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-base mb-1">
                        {{ Auth::user()->invoices()->where('status', 'pending')->count() }}</h3>
                    <p class="text-sm font-medium text-base/70">{{ __('dashboard.unpaid_invoices') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div
            class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-neutral/20 bg-neutral/5">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-neutral/10 rounded-lg">
                        <x-ri-server-line class="size-4 text-base/80" />
                    </div>
                    <h2 class="font-semibold text-base">{{ __('dashboard.active_services') }}</h2>
                </div>
                <a href="{{ route('services') }}"
                    class="text-xs font-medium text-primary hover:text-primary/80 flex items-center gap-1 px-2 py-1 rounded hover:bg-primary/5 transition-colors"
                    wire:navigate>
                    {{ __('dashboard.view_all') }}
                    <x-ri-arrow-right-s-line class="size-3.5" />
                </a>
            </div>
            <div class="p-5">
                <livewire:services.widget status="active" />
            </div>
        </div>

        <div
            class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-neutral/20 bg-neutral/5">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-neutral/10 rounded-lg">
                        <x-ri-bill-line class="size-4 text-base/80" />
                    </div>
                    <h2 class="font-semibold text-base">{{ __('dashboard.unpaid_invoices') }}</h2>
                </div>
                <a href="{{ route('invoices') }}"
                    class="text-xs font-medium text-primary hover:text-primary/80 flex items-center gap-1 px-2 py-1 rounded hover:bg-primary/5 transition-colors"
                    wire:navigate>
                    {{ __('dashboard.view_all') }}
                    <x-ri-arrow-right-s-line class="size-3.5" />
                </a>
            </div>
            <div class="p-5">
                <livewire:invoices.widget :limit="3" />
            </div>
        </div>

        @if (!config('settings.tickets_disabled', false))
            <div
                class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden lg:col-span-2 hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-neutral/20 bg-neutral/5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-neutral/10 rounded-lg">
                            <x-ri-customer-service-line class="size-4 text-base/80" />
                        </div>
                        <h2 class="font-semibold text-base">{{ __('dashboard.open_tickets') }}</h2>
                    </div>
                    <a href="{{ route('tickets') }}"
                        class="text-xs font-medium text-primary hover:text-primary/80 flex items-center gap-1 px-2 py-1 rounded hover:bg-primary/5 transition-colors"
                        wire:navigate>
                        {{ __('dashboard.view_all') }}
                        <x-ri-arrow-right-s-line class="size-3.5" />
                    </a>
                </div>
                <div class="p-5">
                    <livewire:tickets.widget />
                </div>
            </div>
        @endif

        {!! hook('pages.dashboard') !!}
    </div>
</div>
