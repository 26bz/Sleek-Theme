<div class="container max-w-7xl mx-auto px-6 lg:px-8 pt-6 pb-12">
    <div class="grid md:grid-cols-4 gap-6">
        <div class="col-span-3 flex flex-col gap-4">
            @if (Cart::items()->count() === 0)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg p-8 text-center shadow-sm">
                    <div class="flex flex-col items-center space-y-4">
                        <span class="bg-neutral/5 rounded-full p-4">
                            <x-ri-shopping-cart-line class="size-12 text-base/50" />
                        </span>
                        <h1 class="text-2xl font-semibold">{{ __('product.empty_cart') }}</h1>
                        <p class="text-base/70 max-w-md">{{ __('product.empty_cart') }}</p>
                    </div>
                </div>
            @endif

            @foreach (Cart::items() as $item)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg p-4 sm:p-5 shadow-sm flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <h2 class="text-xl font-semibold sm:text-2xl">{{ $item->product->name }}</h2>
                        <div class="text-sm text-base/70 space-y-1">
                            @foreach ($item->config_options as $option)
                                <div>
                                    <span class="font-medium text-base/80">{{ $option['option_name'] }}:</span>
                                    <span>{{ $option['value_name'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                        <div class="text-right sm:text-left">
                            <div class="text-xl font-semibold">
                                {{ $item->price->format($item->price->total * $item->quantity) }}
                            </div>
                            @if ($item->quantity > 1)
                                <div class="text-sm text-base/60">
                                    {{ $item->price }} each
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-2">
                            @if ($item->product->allow_quantity == 'combined')
                                <div class="flex items-center bg-background border border-neutral/20 rounded-lg overflow-hidden">
                                    <x-button.secondary wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                        class="h-full !w-fit">-
                                    </x-button.secondary>
                                    <x-form.input class="h-10 text-center" disabled divClass="!mt-0 !w-14" value="{{ $item->quantity }}" name="quantity" />
                                    <x-button.secondary wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                        class="h-full !w-fit">+
                                    </x-button.secondary>
                                </div>
                            @endif

                            @php
                                $optionsQuery = collect($item->config_options ?? [])
                                    ->filter(fn ($option) => isset($option['value']) && $option['value'] !== '' && $option['value'] !== null)
                                    ->mapWithKeys(fn ($option) => [$option['option_id'] => $option['value']])
                                    ->all();

                                $configQuery = collect($item->checkout_config ?? [])
                                    ->filter(fn ($value) => $value !== '' && $value !== null)
                                    ->all();

                                $routeParams = [
                                    'category' => $item->product->category,
                                    'product' => $item->product,
                                    'edit' => $item->id,
                                    'plan' => $item->plan->id,
                                ];

                                if (!empty($optionsQuery)) {
                                    $routeParams['options'] = $optionsQuery;
                                }

                                if (!empty($configQuery)) {
                                    $routeParams['config'] = $configQuery;
                                }
                            @endphp

                            <a href="{{ route('products.checkout', $routeParams) }}" wire:navigate>
                                <x-button.primary class="h-fit w-fit">
                                    {{ __('product.edit') }}
                                </x-button.primary>
                            </a>

                            <x-button.danger wire:click="removeProduct({{ $item->id }})" class="h-fit !w-fit">
                                <x-loading target="removeProduct({{ $item->id }})" />
                                <div wire:loading.remove wire:target="removeProduct({{ $item->id }})">
                                    {{ __('product.remove') }}
                                </div>
                            </x-button.danger>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-4">
            @if (Cart::items()->count() > 0)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg p-5 shadow-sm sticky top-24 space-y-5">
                    <h2 class="text-2xl font-semibold">{{ __('product.order_summary') }}</h2>

                    @if (!$coupon)
                        <div class="space-y-2">
                            <x-form.input wire:model="coupon" name="coupon" label="Coupon" />
                            <x-button.primary wire:click="applyCoupon" wire:loading.attr="disabled" class="w-full justify-center">
                                <x-loading target="applyCoupon" />
                                <div wire:loading.remove wire:target="applyCoupon">
                                    {{ __('product.apply') }}
                                </div>
                            </x-button.primary>
                        </div>
                    @else
                        <div class="flex items-center justify-between bg-primary/5 border border-primary/20 rounded-lg px-3 py-2">
                            <span class="text-sm font-medium">{{ $coupon->code }}</span>
                            <x-button.secondary wire:click="removeCoupon" class="h-fit !w-fit">
                                {{ __('product.remove') }}
                            </x-button.secondary>
                        </div>
                    @endif

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base/70">{{ __('invoices.subtotal') }}:</span>
                            <span class="font-semibold">{{ $total->format($total->subtotal) }}</span>
                        </div>
                        @if ($total->tax > 0)
                            <div class="flex justify-between">
                                <span class="text-base/70">
                                    {{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)
                                </span>
                                <span class="font-semibold">{{ $total->format($total->tax) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-semibold pt-2 border-t border-neutral/20">
                            <span>{{ __('invoices.total') }}:</span>
                            <span>{{ $total->format($total->total) }}</span>
                        </div>

                        @if (config('settings.tos'))
                            <div class="p-3 rounded-lg bg-neutral/5 border border-neutral/10">
                                <x-form.checkbox wire:model="tos" name="tos">
                                    {{ __('product.tos') }}
                                    <a href="{{ config('settings.tos') }}" target="_blank"
                                        class="text-primary hover:text-primary/80">
                                        {{ __('product.tos_link') }}
                                    </a>
                                </x-form.checkbox>
                            </div>
                        @endif

                        <x-button.primary wire:click="checkout" wire:loading.attr="disabled"
                            class="w-full justify-center">
                            <x-loading target="checkout" />
                            <div wire:loading.remove wire:target="checkout">
                                {{ __('product.checkout') }}
                            </div>
                        </x-button.primary>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
