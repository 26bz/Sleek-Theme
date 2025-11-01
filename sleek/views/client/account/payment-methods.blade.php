<div class="space-y-6 pt-4">
    <div class="space-y-6">
        @if($setupModalVisible)
        <x-modal :title="__('account.payment_methods')" open="true">
            <x-slot name="closeTrigger">
                <div class="flex gap-4">
                    <button wire:click="$set('setupModalVisible', false)" class="text-primary-100">
                        <x-ri-close-fill class="size-6" />
                    </button>
                </div>
            </x-slot>
            @if(count($this->gateways) > 1)
            <x-form.select name="gateway" :label="__('account.input.payment_gateway')" wire:model.live="gateway"
                required>
                @foreach($this->gateways as $gateway)
                <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                @endforeach
            </x-form.select>
            @elseif(count($this->gateways) === 0)
            <p class="text-sm text-red-500">{{ __('account.no_payment_gateways_available') }}</p>
            @endif
            <x-button.primary class="w-full mt-4" wire:click="createBillingAgreement" wire:loading.attr="disabled">
                <x-loading target="createBillingAgreement" />
                <div wire:loading.remove wire:target="createBillingAgreement">
                    {{ __('account.setup_payment_method') }}
                </div>
            </x-button.primary>
            @if ($this->setup)
            <x-modal :title="__('account.setup_payment_method')" open>
                <div class="mt-8">
                    {{ $this->setup }}
                </div>
                <x-slot name="closeTrigger">
                    <div class="flex gap-4">
                        <button wire:confirm="Are you sure?" wire:click="cancelSetup" wire:loading.attr="disabled"
                            wire:target="cancelSetup" class="text-primary-100">
                            <x-ri-close-fill class="size-6" />
                        </button>
                    </div>
                </x-slot>
            </x-modal>
            @endif
        </x-modal>
        @endif
        <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">{{ __('account.saved_payment_methods') }}</h2>
                        <p class="text-sm text-base/60 mt-1">{{ __('account.saved_payment_methods_description') }}</p>
                    </div>

                    @if(count($this->gateways) > 0)
                        <x-button.primary class="w-full sm:w-auto sm:!w-fit flex items-center justify-center gap-2"
                            wire:click="$set('setupModalVisible', true)" wire:loading.attr="disabled"
                            wire:target="setupModalVisible">
                            <x-ri-add-line class="size-4" />
                            {{ __('account.add_payment_method') }}
                        </x-button.primary>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-6">
                @php
                    $groupedAgreements = $billingAgreements->groupBy('gateway.name');
                @endphp

                @if($groupedAgreements->count() > 0)
                    @foreach($groupedAgreements as $gatewayName => $agreements)
                        <div class="space-y-4">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-neutral/10 rounded-lg bg-background p-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="bg-neutral/10 border border-neutral/10 rounded-lg size-12 flex items-center justify-center overflow-hidden">
                                        @if($agreements->first()?->gateway?->meta?->icon)
                                            <img src="{{ $agreements->first()->gateway->meta->icon }}" alt="{{ $gatewayName }}"
                                                class="size-10 object-contain" />
                                        @else
                                            <x-ri-secure-payment-line class="size-6 text-primary" />
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $gatewayName }}</h3>
                                        <p class="text-sm text-base/60">{{ $agreements->count() }} {{ \Illuminate\Support\Str::plural('payment method', $agreements->count()) }}</p>
                                    </div>
                                </div>

                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 text-sm font-medium rounded-full border border-primary/20 bg-primary/10 text-primary">
                                    <x-ri-bank-card-line class="size-4" />
                                    {{ $agreements->count() }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                @foreach($agreements as $agreement)
                                    <div
                                        class="bg-background border border-neutral/10 rounded-lg p-4 sm:p-5 transition-colors hover:border-neutral/30">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="bg-neutral/10 rounded-lg flex items-center justify-center p-3 min-w-[3.5rem]">
                                                    @switch(strtolower($agreement->type))
                                                        @case('visa')<x-icons.visa class="size-8" />@break
                                                        @case('mastercard')<x-icons.mastercard class="size-8" />@break
                                                        @case('amex')<x-icons.amex class="size-8" />@break
                                                        @case('american express')<x-icons.american-express class="size-8" />@break
                                                        @case('discover')<x-icons.discover class="size-8" />@break
                                                        @case('paypal')<x-icons.paypal class="size-8" />@break
                                                        @case('sepa_debit')<x-icons.sepa class="size-8" />@break
                                                        @case('ideal')<x-icons.ideal class="size-8" />@break
                                                        @case('bancontact')<x-icons.bancontact class="size-8" />@break
                                                        @case('sofort')<x-icons.sofort class="size-8" />@break
                                                        @case('us_bank_account')
                                                        @case('bacs_debit')
                                                        @case('au_becs_debit')<x-icons.bank-debit class="size-8" />@break
                                                        @default<x-ri-bank-card-line class="size-6 text-primary" />
                                                    @endswitch
                                                </div>

                                                <div class="space-y-1">
                                                    <p class="font-semibold text-base">{{ $agreement->name }}</p>

                                                    @if($agreement->expiry)
                                                        <p class="text-sm text-base/60">
                                                            {{ __('Expires: :date', ['date' => \Carbon\Carbon::parse($agreement->expiry)->format('m/Y')]) }}
                                                        </p>
                                                    @endif

                                                    @if($agreement->services()->count() > 0)
                                                        <p class="text-xs text-base/50">
                                                            {{ __('account.services_linked', ['count' => $agreement->services()->count()]) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 sm:self-end">
                                                <x-button.danger class="!px-3 !py-2 inline-flex items-center justify-center"
                                                    x-on:click="$store.confirmation.confirm({
                                                        title: '{{ __('account.remove_payment_method') }}',
                                                        message: '{{ __('account.remove_payment_method_confirm', ['name' => $agreement->name]) }}',
                                                        confirmText: '{{ __('account.confirm') }}',
                                                        cancelText: '{{ __('account.cancel') }}',
                                                        callback: () => $wire.removePaymentMethod('{{ $agreement->ulid }}')
                                                    })">
                                                    <x-ri-delete-bin-line class="size-4" />
                                                </x-button.danger>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div
                        class="bg-background border border-dashed border-neutral/20 rounded-lg p-8 text-center flex flex-col items-center gap-3">
                        <x-ri-bank-card-line class="size-12 text-base/30" />
                        <p class="text-base/70">{{ __('account.no_saved_payment_methods') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                <h2 class="text-xl font-semibold">{{ __('account.recent_transactions') }}</h2>
            </div>

            <div class="p-6 space-y-4">
                @forelse ($transactions as $transaction)
                    <a href="{{ route('invoices.show', $transaction->invoice) }}" wire:navigate
                        class="block group">
                        <div
                            class="bg-background border border-neutral/10 rounded-lg p-4 transition-colors group-hover:border-neutral/30">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 text-sm">
                                    <div class="bg-secondary/10 p-2 rounded-lg w-fit">
                                        <x-ri-bill-line class="size-5 text-secondary" />
                                    </div>
                                    <div class="space-y-1">
                                        <p class="font-medium text-base">
                                            {{ $transaction->transaction_id ? __('Transaction: :id', ['id' => $transaction->transaction_id]) : __('Transaction ID N/A') }}
                                        <div class="flex flex-wrap items-center gap-2 text-base/60 text-xs">
                                            <span class="inline-flex items-center gap-1">
                                                <x-ri-wallet-3-line class="size-3" />
                                                {{ $transaction->formattedAmount }}
                                            </span>
                                            <span class="hidden sm:inline text-base/40">•</span>
                                            <span>{{ $transaction->gateway ? $transaction->gateway->name : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-1 text-xs sm:text-sm text-base/60">
                                    <div>
                                        @if($transaction->status === \App\Enums\InvoiceTransactionStatus::Succeeded)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-success/10 text-success border border-success/20 text-xs font-medium">
                                                <x-ri-check-line class="size-3 mr-1" />
                                                {{ __('invoices.transaction_statuses.succeeded') }}
                                            </span>
                                        @elseif($transaction->status === \App\Enums\InvoiceTransactionStatus::Processing)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-warning/10 text-warning border border-warning/20 text-xs font-medium">
                                                <x-ri-loader-5-fill class="size-3 mr-1 animate-spin" />
                                                {{ __('invoices.transaction_statuses.processing') }}
                                            </span>
                                        @elseif($transaction->status === \App\Enums\InvoiceTransactionStatus::Failed)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-error/10 text-error border border-error/20 text-xs font-medium">
                                                <x-ri-close-line class="size-3 mr-1" />
                                                {{ __('invoices.transaction_statuses.failed') }}
                                            </span>
                                        @endif
                                    </div>
                                    <span>{{ $transaction->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div
                        class="bg-background border border-dashed border-neutral/20 rounded-lg p-8 text-center text-base/60">
                        {{ __('account.no_recent_transactions') !== 'account.no_recent_transactions' ? __('account.no_recent_transactions') : 'You have no recent transactions yet.' }}
                    </div>
                @endforelse

                <div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>