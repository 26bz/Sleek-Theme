<div class="flex flex-col space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('Shopping Cart') }}</h1>
        @if (!Cart::get()->isEmpty())
            <span class="text-sm text-base/70">{{ Cart::get()->count() }}
                {{ Cart::get()->count() == 1 ? __('item') : __('items') }}</span>
        @endif
    </div>

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        <div class="flex flex-col col-span-3 gap-4">
            @if (Cart::get()->isEmpty())
                <div class="bg-background-secondary border border-neutral/20 rounded-lg p-8 text-center">
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <div class="bg-neutral/5 rounded-full p-4 inline-block">
                            <x-ri-shopping-cart-line class="size-12 text-base/50" />
                        </div>
                        <h2 class="text-xl font-medium">
                            {{ __('product.empty_cart') }}
                        </h2>
                        <p class="text-base/70 max-w-md mx-auto">
                            {{ __('Your shopping cart is currently empty.') }}
                        </p>
                    </div>
                </div>
            @endif

            @foreach (Cart::get() as $key => $item)
                <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between p-4 sm:p-5 gap-4">
                        <div class="flex flex-col gap-2">
                            <h2 class="text-lg font-medium">
                                {{ $item->product->name }}
                            </h2>
                            @if (count($item->configOptions) > 0)
                                <div class="text-sm text-base/70 bg-neutral/5 p-3 rounded-lg border border-neutral/10">
                                    @foreach ($item->configOptions as $option)
                                        <div class="flex justify-between gap-4 mb-1 last:mb-0">
                                            <span class="font-medium">{{ $option->option_name }}:</span>
                                            <span>{{ $option->value_name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col sm:items-end gap-4">
                            <div class="bg-neutral/5 px-3 py-2 rounded-lg border border-neutral/10 text-right">
                                <span class="text-lg font-medium text-primary">
                                    {{ $item->price->format($item->price->price * $item->quantity) }}
                                </span>
                                @if ($item->quantity > 1)
                                    <div class="text-xs text-base/70 mt-1">
                                        {{ $item->price }} {{ __('each') }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2 justify-end">
                                @if ($item->product->allow_quantity == 'combined')
                                    <div
                                        class="flex items-center bg-background rounded-lg border border-neutral/20 overflow-hidden">
                                        <button
                                            wire:click="updateQuantity({{ $key }}, {{ $item->quantity - 1 }})"
                                            class="px-3 py-2 hover:bg-neutral/5 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="px-3 font-medium">{{ $item->quantity }}</span>
                                        <button
                                            wire:click="updateQuantity({{ $key }}, {{ $item->quantity + 1 }})"
                                            class="px-3 py-2 hover:bg-neutral/5 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <a href="{{ route('products.checkout', [$item->product->category, $item->product, 'edit' => $key]) }}"
                                    wire:navigate>
                                    <x-button.secondary class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('product.edit') }}
                                    </x-button.secondary>
                                </a>

                                <button wire:click="removeProduct({{ $key }})"
                                    class="flex items-center px-3 py-2 text-error hover:bg-error/5 border border-neutral/20 rounded-lg transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    {{ __('product.remove') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex flex-col gap-4">
            @if (!Cart::get()->isEmpty())
                <div
                    class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm sticky top-24">
                    <div class="border-b border-neutral/20 p-4">
                        <h2 class="font-medium">{{ __('product.order_summary') }}</h2>
                    </div>
                    <div class="p-5 space-y-5">
                        @if (!$coupon)
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('Discount Code') }}</label>
                                <div class="flex gap-2">
                                    <x-form.input wire:model="coupon" name="coupon" placeholder="Enter code"
                                        class="flex-grow" divClass="!mt-0" />
                                    <x-button.primary wire:click="applyCoupon" wire:loading.attr="disabled"
                                        class="whitespace-nowrap">
                                        <span wire:loading wire:target="applyCoupon">
                                            <x-ri-loader-4-line class="size-4 animate-spin mr-1" />
                                        </span>
                                        <span wire:loading.remove wire:target="applyCoupon">
                                            {{ __('product.apply') }}
                                        </span>
                                    </x-button.primary>
                                </div>
                            </div>
                        @else
                            <div
                                class="flex justify-between items-center bg-neutral/5 p-3 rounded-lg border border-neutral/10">
                                <div>
                                    <span class="text-xs text-base/70">{{ __('Coupon applied') }}</span>
                                    <div class="font-medium">{{ $coupon->code }}</div>
                                </div>
                                <button wire:click="removeCoupon"
                                    class="text-base/70 hover:text-error transition-colors duration-200">
                                    <x-ri-close-circle-line class="size-5" />
                                </button>
                            </div>
                        @endif

                        <div class="bg-neutral/5 p-4 rounded-lg border border-neutral/10 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-base/70">{{ __('invoices.subtotal') }}</span>
                                <span class="font-medium">{{ $total->format($total->price - $total->tax) }}</span>
                            </div>

                            @if ($total->tax > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-base/70">{{ \App\Classes\Settings::tax()->name }}
                                        ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                                    <span class="font-medium">{{ $total->formatted->tax }}</span>
                                </div>
                            @endif

                            <div class="border-t border-neutral/10 mt-2 pt-2"></div>

                            <div class="flex justify-between items-center">
                                <span class="font-medium">{{ __('invoices.total') }}</span>
                                <span class="text-lg font-semibold text-primary">{{ $total }}</span>
                            </div>
                        </div>

                        @if ($total->price > 0)
                            @if (count($gateways) > 1)
                                <div>
                                    <x-form.select wire:model.live="gateway" name="gateway" :label="__('product.payment_method')">
                                        @foreach ($gateways as $gateway)
                                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            @endif

                            @if (Auth::check() &&
                                    Auth::user()->credits()->where('currency_code', Cart::get()->first()->price->currency->code)->exists() &&
                                    Auth::user()->credits()->where('currency_code', Cart::get()->first()->price->currency->code)->first()->amount > 0)
                                <div class="p-3 rounded-lg bg-neutral/5 border border-neutral/10">
                                    <x-form.checkbox wire:model="use_credits" name="use_credits"
                                        label="Use Credits" />
                                </div>
                            @endif
                        @endif

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
                            class="w-full justify-center py-3">
                            <span class="flex items-center justify-center gap-2" wire:loading wire:target="checkout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 animate-spin"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>{{ __('Processing...') }}</span>
                            </span>
                            <span class="flex items-center justify-center gap-2" wire:loading.remove wire:target="checkout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>{{ __('product.checkout') }}</span>
                            </span>
                        </x-button.primary>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
