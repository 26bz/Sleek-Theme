<div class="container mt-14 space-y-4">
    <x-navigation.breadcrumb />

    @forelse ($services as $service)
        <a href="{{ route('services.show', $service) }}" wire:navigate>
            <div class="bg-background-secondary hover:bg-background-secondary/90 border border-neutral/20 p-5 rounded-xl mb-4 transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="bg-secondary/10 p-2 rounded-lg">
                            <x-ri-instance-line class="size-5 text-secondary" />
                        </div>
                        <span class="font-medium truncate max-w-[16rem] sm:max-w-xs md:max-w-sm">
                            {{ $service->product->name }}
                        </span>
                    </div>
                    <div class="size-5 rounded-md p-0.5
                        @if ($service->status == 'active') text-success bg-success/20
                        @elseif($service->status == 'suspended' || $service->status == 'cancelled') text-inactive bg-inactive/20
                        @else text-warning bg-warning/20
                        @endif">
                        @if ($service->status == 'active')
                            <x-ri-checkbox-circle-fill />
                        @elseif($service->status == 'suspended' || $service->status == 'cancelled')
                            <x-ri-forbid-fill />
                        @elseif($service->status == 'pending')
                            <x-ri-error-warning-fill />
                        @endif
                    </div>
                </div>
                <p class="text-base text-sm text-base/70">
                    {{ $service->product->category->name }}
                    {{ in_array($service->plan->type, ['recurring'])
                        ? ' - ' . __('services.every_period', [
                            'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                            'unit' => trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit), $service->plan->billing_period),
                        ])
                        : '' }}
                    {{ $service->expires_at ? '- ' . __('services.expires_at') . ': ' . $service->expires_at->format('M d, Y') : ''}}
                </p>
            </div>
        </a>
    @empty
        <div class="bg-background-secondary border border-neutral/20 p-5 rounded-lg text-center">
            <p class="text-base text-sm">{{ __('services.no_services') }}</p>
        </div>
    @endforelse

    {{ $services->links() }}
</div>
