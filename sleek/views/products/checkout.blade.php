<div class="flex flex-col space-y-6">
    <x-navigation.breadcrumb />

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        <div class="flex flex-col gap-6 w-full col-span-3">
            <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
                <div class="border-b border-neutral/20 p-4">
                    <h1 class="text-2xl font-bold">Checkout for {{ $product->name }}</h1>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        @if ($product->image)
                            <div class="w-full md:w-1/4 flex-shrink-0">
                                <div class="overflow-hidden rounded-lg border border-neutral/20 bg-background shadow-sm">
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-auto aspect-square object-contain p-4">
                                </div>
                            </div>
                        @endif

                        <div class="flex-grow">
                            <div class="prose dark:prose-invert max-w-none text-base/70 mb-4">
                                {!! $product->description !!}
                            </div>

                            @if ($product->stock === 0)
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-error/10 text-error border border-error/20">
                                    <x-ri-error-warning-fill class="size-4 mr-1.5" />
                                    {{ __('product.out_of_stock', ['product' => $product->name]) }}
                                </span>
                            @elseif($product->stock > 0)
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-success/10 text-success border border-success/20">
                                    <x-ri-checkbox-circle-fill class="size-4 mr-1.5" />
                                    In stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if ($product->availablePlans()->count() > 1)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
                    <div class="border-b border-neutral/20 p-4">
                        <h2 class="font-medium">{{ __('product.select_plan') }}</h2>
                    </div>
                    <div class="p-6">
                        <x-form.select wire:model.live="plan_id" name="plan_id"
                            label="{{ __('product.available_plans') }}">
                            @foreach ($product->availablePlans() as $availablePlan)
                                <option value="{{ $availablePlan->id }}">
                                    {{ $availablePlan->name }} -
                                    {{ $availablePlan->price() }}
                                    @if ($availablePlan->price()->has_setup_fee)
                                        + {{ $availablePlan->price()->formatted->setup_fee }}
                                        {{ __('product.setup_fee') }}
                                    @endif
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
            @endif

            @if ($product->configOptions->count() > 0)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
                    <div class="border-b border-neutral/20 p-4">
                        <h2 class="font-medium">{{ __('product.configuration_options') }}</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach ($product->configOptions as $configOption)
                                @php
                                    $showPriceTag =
                                        $configOption->children
                                            ->filter(
                                                fn($value) => !$value->price(
                                                    billing_period: $plan->billing_period,
                                                    billing_unit: $plan->billing_unit,
                                                )->is_free,
                                            )
                                            ->count() > 0;
                                @endphp
                                <div class="border-b border-neutral/10 pb-5 last:border-b-0 last:pb-0">
                                    <x-form.configoption :config="$configOption" :name="'configOptions.' . $configOption->id" :showPriceTag="$showPriceTag"
                                        :plan="$plan">
                                        @if ($configOption->type == 'select')
                                            @foreach ($configOption->children as $configOptionValue)
                                                <option value="{{ $configOptionValue->id }}">
                                                    {{ $configOptionValue->name }}
                                                    {{ $showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}
                                                </option>
                                            @endforeach
                                        @elseif($configOption->type == 'radio')
                                            @foreach ($configOption->children as $configOptionValue)
                                                <div class="flex items-center gap-2 py-1.5">
                                                    <input type="radio" id="{{ $configOptionValue->id }}"
                                                        name="{{ $configOption->id }}"
                                                        wire:model.live="configOptions.{{ $configOption->id }}"
                                                        value="{{ $configOptionValue->id }}"
                                                        class="text-primary focus:ring-primary/30" />
                                                    <label for="{{ $configOptionValue->id }}" class="text-sm">
                                                        {{ $configOptionValue->name }}
                                                        @if (
                                                            $showPriceTag &&
                                                                $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available)
                                                            <span class="text-primary font-medium ml-1">
                                                                {{ $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) }}
                                                            </span>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </x-form.configoption>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if (count($this->getCheckoutConfig()) > 0)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
                    <div class="border-b border-neutral/20 p-4">
                        <h2 class="font-medium">{{ __('product.additional_options') }}</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach ($this->getCheckoutConfig() as $configOption)
                                @php $configOption = (object) $configOption; @endphp
                                <div class="border-b border-neutral/10 pb-5 last:border-b-0 last:pb-0">
                                    <x-form.configoption :config="$configOption" :name="'checkoutConfig.' . $configOption->name">
                                        @if ($configOption->type == 'select')
                                            @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                                                <option value="{{ $configOptionValue }}">
                                                    {{ $configOptionValueName }}
                                                </option>
                                            @endforeach
                                        @elseif($configOption->type == 'radio')
                                            @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                                                <div class="flex items-center gap-2 py-1.5">
                                                    <input type="radio" id="{{ $configOptionValue }}"
                                                        name="{{ $configOption->name }}"
                                                        wire:model.live="checkoutConfig.{{ $configOption->name }}"
                                                        value="{{ $configOptionValue }}"
                                                        class="text-primary focus:ring-primary/30" />
                                                    <label for="{{ $configOptionValue }}" class="text-sm">
                                                        {{ $configOptionValueName }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </x-form.configoption>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col gap-4 w-full col-span-1">
            <div
                class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm sticky top-24">
                <div class="border-b border-neutral/20 p-4">
                    <h2 class="font-medium">Order Summary</h2>
                </div>

                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-base/70">Product:</span>
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>

                        @if ($product->availablePlans()->count() > 1)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-base/70">{{ __('product.plan') }}:</span>
                                <span class="font-medium">{{ $plan->name }}</span>
                            </div>
                        @endif

                        <div class="border-t border-neutral/10 my-2"></div>

                        <div class="bg-neutral/5 p-3 rounded-lg border border-neutral/10">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Total today:</span>
                                <span class="text-lg font-semibold text-primary">{{ $total }}</span>
                            </div>

                            @if ($total->setup_fee && $plan->type == 'recurring')
                                <div class="flex justify-between items-center text-sm mt-1">
                                    <span
                                        class="text-base/60">{{ __('product.then_after_x', ['time' => $plan->billing_period . ' ' . trans_choice(__('services.billing_cycles.' . $plan->billing_unit), $plan->billing_period)]) }}:</span>
                                    <span
                                        class="font-medium">{{ $total->format($total->price - $total->setup_fee) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (($product->stock > 0 || !$product->stock) && $product->price()->available)
                        <div>
                            <x-button.primary wire:click="checkout" wire:loading.attr="disabled"
                                class="w-full justify-center py-3">
                                <div class="flex items-center">
                                    <span wire:loading wire:target="checkout">
                                        <x-ri-loader-5-fill class="size-5 mr-2 animate-spin" />
                                        Processing...
                                    </span>
                                    <span wire:loading.remove wire:target="checkout">
                                        <x-ri-shopping-cart-fill class="size-5 mr-2" />
                                        Checkout
                                    </span>
                                </div>
                            </x-button.primary>
                        </div>
                    @else
                        <div class="bg-error/10 border border-error/20 text-error p-3 rounded-lg text-center">
                            {{ __('product.out_of_stock', ['product' => $product->name]) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
