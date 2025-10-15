<div class="space-y-6 pt-4">
    <x-navigation.breadcrumb />

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">My Services</h1>
    </div>

    <div class="grid gap-4">
        @foreach ($services as $service)
            <a href="{{ route('services.show', $service) }}" class="block group" wire:navigate>
                <div
                    class="bg-background-secondary border border-neutral/20 hover:border-neutral/30 p-5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start md:items-center gap-4 flex-1 min-w-0">
                            <div class="bg-neutral/10 p-3 rounded-lg group-hover:bg-primary/10 transition-colors">
                                <x-ri-instance-line
                                    class="size-5 text-base/80 group-hover:text-primary transition-colors" />
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-lg group-hover:text-primary transition-colors truncate">
                                    {{ $service->product->name }}</h3>
                                <p class="text-sm text-base/60">{{ $service->product->category->name }}</p>

                                <div class="mt-2 text-sm text-base/70 space-y-1">
                                    @if (in_array($service->plan->type, ['recurring']))
                                        <p class="flex items-center gap-2">
                                            <x-ri-calendar-line class="size-3.5 text-primary/70" />
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
                                            <x-ri-time-line class="size-3.5 text-primary/70" />
                                            {{ __('services.expires_at') }}:
                                            {{ $service->expires_at->format('M d, Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 flex-shrink-0">
                            <div class="text-right hidden md:block">
                                <p class="text-sm text-base/60">Price</p>
                                <p class="font-semibold text-primary">{{ $service->formattedPrice }}</p>
                            </div>

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
                                    <x-ri-checkbox-circle-fill class="mr-1.5 size-4" /> Active
                                @elseif($service->status == 'suspended')
                                    <x-ri-forbid-fill class="mr-1.5 size-4" /> Suspended
                                @elseif($service->status == 'cancelled')
                                    <x-ri-close-circle-fill class="mr-1.5 size-4" /> Cancelled
                                @elseif($service->status == 'pending')
                                    <x-ri-error-warning-fill class="mr-1.5 size-4" /> Pending
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach

        @if (count($services) === 0)
            <div class="bg-background-secondary border border-neutral/20 p-8 rounded-xl text-center">
                <div class="flex flex-col items-center justify-center gap-3">
                    <div class="bg-neutral/10 p-4 rounded-full">
                        <x-ri-shopping-bag-3-line class="size-8 text-base/50" />
                    </div>
                    <h3 class="text-xl font-semibold">No Services Found</h3>
                    <p class="text-base/70">You don't have any active services yet. Browse our products to get started.
                    </p>
                    <a href="{{ route('services') }}" class="mt-2">
                        <x-button.primary>
                            <x-ri-shopping-cart-fill class="size-4 mr-2" />
                            Browse Products
                        </x-button.primary>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-4">
        {{ $services->links() }}
    </div>
</div>
