@if ($services->count() > 0)
    <div class="space-y-3">
        @foreach ($services as $service)
            <a href="{{ route('services.show', $service) }}" class="block group" wire:navigate>
                <div
                    class="bg-background border border-neutral/20 hover:border-neutral/30 p-4 rounded-xl transition-all duration-200 hover:shadow-sm group-hover:bg-background-secondary/30">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-neutral/10 p-2.5 rounded-lg group-hover:bg-primary/10 transition-colors">
                                <x-ri-instance-line
                                    class="size-5 text-base/80 group-hover:text-primary transition-colors" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-base group-hover:text-primary transition-colors">
                                    {{ $service->product->name }}</h3>
                                <p class="text-xs text-base/60">{{ $service->product->category->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                            @if ($service->status == 'active') bg-success/10 text-success
                            @elseif($service->status == 'suspended') bg-inactive/10 text-inactive
                            @else bg-warning/10 text-warning @endif">
                                @if ($service->status == 'active')
                                    <x-ri-checkbox-circle-fill class="mr-1 size-3" /> Active
                                @elseif($service->status == 'suspended')
                                    <x-ri-forbid-fill class="mr-1 size-3" /> Suspended
                                @elseif($service->status == 'pending')
                                    <x-ri-error-warning-fill class="mr-1 size-3" /> Pending
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="text-sm text-base/70 space-y-1">
                        @if (in_array($service->plan->type, ['recurring']))
                            <p class="flex items-center gap-2">
                                <x-ri-calendar-line class="size-3.5 opacity-60" />
                                {{ __('services.every_period', [
                                    'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                                    'unit' => trans_choice(
                                        __('services.billing_cycles.' . $service->plan->billing_unit),
                                        $service->plan->billing_period,
                                    ),
                                ]) }}
                            </p>
                        @endif
                        @if ($service->expires_at)
                            <p class="flex items-center gap-2">
                                <x-ri-time-line class="size-3.5 opacity-60" />
                                {{ __('services.expires_at') }}: {{ $service->expires_at->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@else
    <div class="bg-background-secondary border border-neutral/20 p-6 rounded-xl text-center">
        <div class="flex flex-col items-center justify-center gap-2">
            <div class="bg-neutral/5 rounded-full p-4 mb-1">
                <x-ri-instance-line class="size-6 text-base/50" />
            </div>
            <p class="font-medium">{{ __('No active services') }}</p>
            <p class="text-xs text-base/60">{{ __('Once you purchase a service, it will appear here for quick access.') }}</p>
        </div>
    </div>
@endif
