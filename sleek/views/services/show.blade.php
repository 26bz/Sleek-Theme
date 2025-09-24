<div class="space-y-6">
    <x-navigation.breadcrumb />

    @if ($invoice = $service->invoices()->where('status', 'pending')->first())
        <div class="w-full">
            <div class="bg-warning/10 border border-warning/20 text-warning p-4 rounded-lg flex items-center gap-3">
                <div class="flex-shrink-0">
                    <x-ri-error-warning-fill class="size-5" />
                </div>
                <div>
                    <p class="font-medium">
                        {{ __('services.outstanding_invoice') }}
                        <a href="{{ route('invoices.show', $invoice) }}"
                            class="underline hover:text-warning/80 underline-offset-2 font-semibold">
                            {{ __('services.view_and_pay') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-background-secondary border border-neutral/20 p-6 rounded-xl shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 border-b border-neutral/10 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-neutral/10 p-3 rounded-lg">
                    <x-ri-instance-line class="size-6 text-primary" />
                </div>
                <h1 class="text-2xl font-bold">{{ $service->product->name }}</h1>
            </div>

            <div>
                @if ($service->cancellation && $service->status == 'active')
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full bg-warning/10 text-warning border border-warning/20">
                        <x-ri-timer-line class="mr-1.5 size-4" />
                        {{ __('services.statuses.cancellation_pending') }}
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border
                        {{ $service->status == 'active'
                            ? 'bg-success/10 text-success border-success/20'
                            : ($service->status == 'suspended'
                                ? 'bg-inactive/10 text-inactive border-inactive/20'
                                : ($service->status == 'cancelled'
                                    ? 'bg-error/10 text-error border-error/20'
                                    : 'bg-warning/10 text-warning border-warning/20')) }}">
                        @if ($service->status == 'active')
                            <x-ri-checkbox-circle-fill class="mr-1.5 size-4" /> {{ __('services.statuses.active') }}
                        @elseif($service->status == 'suspended')
                            <x-ri-forbid-fill class="mr-1.5 size-4" /> {{ __('services.statuses.suspended') }}
                        @elseif($service->status == 'cancelled')
                            <x-ri-close-circle-fill class="mr-1.5 size-4" /> {{ __('services.statuses.cancelled') }}
                        @elseif($service->status == 'pending')
                            <x-ri-error-warning-fill class="mr-1.5 size-4" /> {{ __('services.statuses.pending') }}
                        @endif
                    </span>
                @endif
            </div>
        </div>

        Service Details Grid <div class="grid md:grid-cols-2 gap-8">
            Left Column: Service Details <div>
                <h2 class="text-lg font-semibold mb-4">{{ __('services.product_details') }}</h2>

                <div class="space-y-4">
                    Service Details List <div
                        class="bg-background rounded-lg border border-neutral/10 divide-y divide-neutral/10">
                        Price <div class="flex justify-between py-3 px-4">
                            <span class="text-sm text-base/70">{{ __('services.price') }}</span>
                            <span class="font-medium text-primary">{{ $service->formattedPrice }}</span>
                        </div>

                        Billing Cycle @if ($service->plan->type == 'recurring')
                            <div class="flex justify-between py-3 px-4">
                                <span class="text-sm text-base/70">{{ __('services.billing_cycle') }}</span>
                                <span
                                    class="font-medium">{{ __('services.every_period', [
                                        'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                                        'unit' => trans_choice(
                                            __('services.billing_cycles.' . $service->plan->billing_unit),
                                            $service->plan->billing_period,
                                        ),
                                    ]) }}</span>
                            </div>

                            Expiration Date <div class="flex justify-between py-3 px-4">
                                <span class="text-sm text-base/70">{{ __('services.expires_at') }}</span>
                                <span
                                    class="font-medium">{{ $service->expires_at ? $service->expires_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        @endif

                        Custom Fields @foreach ($fields as $field)
                            <div class="flex justify-between py-3 px-4">
                                <span class="text-sm text-base/70">{{ $field['label'] }}</span>
                                <span class="font-medium">{{ $field['text'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            Right Column: Actions @if ($service->cancellable || $service->upgradable || count($buttons) > 0)
                <div>
                    <h2 class="text-lg font-semibold mb-4">{{ __('services.actions') }}</h2>

                    Primary Actions <div class="flex flex-wrap gap-3 mb-4">
                        @if ($service->upgradable)
                            <a href="{{ route('services.upgrade', $service->id) }}">
                                <x-button.primary class="flex items-center gap-2">
                                    <x-ri-arrow-up-line class="size-4" />
                                    {{ __('services.upgrade') }}
                                </x-button.primary>
                            </a>
                        @endif

                        @if ($service->upgrade()->where('status', 'pending')->exists())
                            <x-button.primary class="flex items-center gap-2 opacity-70 cursor-not-allowed"
                                @click="Alpine.store('notifications').addNotification([{message: '{{ __('services.upgrade_pending') }}', type: 'error'}])">
                                <x-ri-time-line class="size-4" />
                                {{ __('services.upgrade') }}
                            </x-button.primary>
                        @endif

                        @if ($service->cancellable)
                            <x-button.danger class="flex items-center gap-2" wire:click="$set('showCancel', true)">
                                <span wire:loading.remove wire:target="$set('showCancel', true)">
                                    <x-ri-close-circle-line class="size-4" />
                                    {{ __('services.cancel') }}
                                </span>
                                <x-loading target="$set('showCancel', true)" />
                            </x-button.danger>
                        @endif
                    </div>

                    Additional Action Buttons @if (count($buttons) > 0)
                        <div class="bg-background rounded-lg border border-neutral/10 p-4">
                            <h3 class="text-sm font-medium mb-3">{{ __('services.additional_actions') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($buttons as $button)
                                    @if (isset($button['function']))
                                        <x-button.secondary class="flex items-center gap-2"
                                            wire:click="goto('{{ $button['function'] }}')">
                                            {{ $button['label'] }}
                                        </x-button.secondary>
                                    @else
                                        <a href="{{ $button['url'] }}"
                                            @if (!empty($button['target'])) target="{{ $button['target'] }}" @endif
                                            @if (($button['target'] ?? null) === '_blank') rel="noopener noreferrer" @endif>
                                            <x-button.secondary class="flex items-center gap-2">
                                                {{ $button['label'] }}
                                            </x-button.secondary>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    Cancellation Modal @if ($showCancel)
        <x-modal open="true" title="{{ __('services.cancellation', ['service' => $service->product->name]) }}"
            width="max-w-3xl">
            <livewire:services.cancel :service="$service" />
            <x-slot name="closeTrigger">
                <div class="flex gap-4">
                    <button wire:click="$set('showCancel', false)" @click="open = false"
                        class="text-base/70 hover:text-base transition-colors duration-200">
                        <x-ri-close-fill class="size-6" />
                    </button>
                </div>
            </x-slot>
        </x-modal>
    @endif

    Extension Views @if (count($views) > 0)
        <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
            Tabs Navigation @if (count($views) > 1)
                <div class="border-b border-neutral/10">
                    <div class="flex overflow-x-auto">
                        @foreach ($views as $view)
                            <button wire:click="changeView('{{ $view['name'] }}')"
                                class="px-6 py-3 font-medium text-sm focus:outline-none whitespace-nowrap
                        {{ $view['name'] == $currentView ? 'border-b-2 border-primary text-primary' : 'text-base/70 hover:text-base hover:bg-neutral/5' }}">
                                {{ $view['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            View Content <div class="p-6">
                Loading Spinner <div class="flex justify-center py-8" wire:loading wire:target="changeView">
                    <x-loading target="changeView" />
                </div>

                View Content <div wire:loading.remove wire:target="changeView">
                    {!! $extensionView !!}
                </div>
            </div>
        </div>
    @endif
</div>
