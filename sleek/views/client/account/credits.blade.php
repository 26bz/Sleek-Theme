<div class="space-y-6 pt-4">
    <x-navigation.breadcrumb />

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">{{ __('account.credits') }}</h1>
            <p class="text-sm text-base/60 mt-1">{{ __('Manage your account credits and add funds') }}</p>
        </div>
    </div>

    @if (Auth::user()->credits->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
            @foreach (Auth::user()->credits as $credit)
                <div
                    class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="border-b border-neutral/20 p-3 flex justify-between items-center">
                        <h3 class="font-medium">{{ $credit->currency->name }}</h3>
                        <span
                            class="text-xs px-2 py-1 bg-neutral/5 rounded-full border border-neutral/10">{{ $credit->currency->code }}</span>
                    </div>
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-primary/10 p-2 rounded-full mr-3">
                                <x-ri-wallet-3-line class="size-5 text-primary" />
                            </div>
                            <div>
                                <p class="text-xs text-base/60">{{ __('Available Balance') }}</p>
                                <p class="text-xl font-bold text-primary">{{ $credit->formattedAmount }}</p>
                            </div>
                        </div>
                        <a href="#add-credit" class="text-primary hover:text-primary/80 transition-colors duration-200">
                            <x-ri-add-circle-line class="size-5" />
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-background-secondary border border-neutral/20 rounded-lg p-6 text-center mb-6 shadow-sm">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="bg-neutral/5 rounded-full p-4 border border-neutral/10">
                    <x-ri-wallet-3-line class="size-12 text-base/50" />
                </div>
                <h3 class="text-xl font-medium">{{ __('No Credits Available') }}</h3>
                <p class="text-base/70 max-w-md mx-auto">{{ __('account.no_credit') }}</p>
            </div>
        </div>
    @endif

    <div id="add-credit"
        class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm scroll-mt-24">
        <div class="border-b border-neutral/20 p-4">
            <h2 class="font-medium">{{ __('account.add_credit') }}</h2>
            <p class="text-sm text-base/60 mt-1">{{ __('Add funds to your account balance.') }}</p>
        </div>

        <div class="p-6">
            <form wire:submit.prevent="addCredit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.select name="currency" :label="__('account.input.currency')" wire:model.live="currency" required>
                        @foreach (\App\Models\Currency::all() as $currency)
                            <option value="{{ $currency->code }}">{{ $currency->code }} - {{ $currency->name }}
                            </option>
                        @endforeach
                    </x-form.select>

                    <x-form.input x-mask:dynamic="$money($input, '.', '', 2)" name="amount" type="number"
                        :label="__('account.input.amount')" :placeholder="__('account.input.amount_placeholder')" wire:model.live.debounce.250ms="amount" required />

                    <x-form.select name="gateway" :label="__('product.payment_method')" wire:model.live="gateway" required
                        class="md:col-span-2">
                        @foreach ($gateways as $gatewayy)
                            <option value="{{ $gatewayy->id }}" wire:key="{{ $gatewayy->id }}"
                                @if ($gatewayy->id == $gateway) selected @endif>
                                {{ $gatewayy->name }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="flex justify-end mt-6">
                    <x-button.primary
                        class="px-6 py-2.5 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
                        type="submit">
                        <span class="flex items-center gap-2">
                            <x-ri-wallet-3-line class="size-4" />
                            <span>{{ __('account.add_credit') }}</span>
                        </span>
                    </x-button.primary>
                </div>
            </form>
        </div>
    </div>
</div>
