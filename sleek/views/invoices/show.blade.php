<div class="space-y-6 pt-4">
    <div class="space-y-6" @if ($checkPayment) wire:poll.5s="checkPaymentStatus" @endif>
        @if ($this->pay || $showPayModal)
            @include('invoices.partials.payment-modal')
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold">Invoice #{{ $invoice->number }}</h1>

            <x-button.link wire:click="downloadPDF"
                class="flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80">
                <span wire:loading wire:target="downloadPDF">
                    <x-ri-loader-5-fill class="size-5 animate-spin" />
                </span>
                <span wire:loading.remove wire:target="downloadPDF">
                    <x-ri-download-line class="size-5" />
                    Download PDF
                </span>
            </x-button.link>
        </div>

        <div class="bg-background-secondary border border-neutral/20 rounded-2xl shadow-sm overflow-hidden">
            <div class="border-b border-neutral/20 px-6 py-4 flex flex-wrap gap-3 justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">Invoice Details</h2>
                    <p class="text-sm text-base/60">Issued on {{ $invoice->created_at->format('d M Y') }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($invoice->status == 'paid')
                        <span
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border border-success/20 bg-success/10 text-success">
                            <x-ri-checkbox-circle-fill class="mr-1.5 size-4" /> Paid
                        </span>
                    @elseif($invoice->status == 'cancelled')
                        <span
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border border-error/20 bg-error/10 text-error">
                            <x-ri-close-circle-fill class="mr-1.5 size-4" /> Cancelled
                        </span>
                    @elseif($invoice->status == 'pending')
                        <span
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border border-warning/20 bg-warning/10 text-warning">
                            <x-ri-error-warning-fill class="mr-1.5 size-4" /> Pending
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-8">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium mb-3 text-base/70 uppercase tracking-wide">Issued To</h3>
                        <div class="bg-background rounded-lg border border-neutral/20 p-4 space-y-1">
                            <p class="font-semibold">{{ $invoice->user->name }}</p>
                            @php
                                $invoiceProperties = $invoice->user
                                    ->properties()
                                    ->with('parent_property')
                                    ->whereHas('parent_property', fn($query) => $query->where('show_on_invoice', true))
                                    ->get();
                            @endphp
                            @foreach ($invoiceProperties as $property)
                                <p class="text-sm text-base/70">{{ $property->value }}</p>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium mb-3 text-base/70 uppercase tracking-wide">Bill From</h3>
                        <div
                            class="bg-background rounded-lg border border-neutral/20 p-4 text-sm text-base/70 whitespace-pre-line">
                            {!! nl2br(e(config('settings.bill_to_text', config('settings.company_name')))) !!}
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h3 class="text-sm font-medium text-base/70 uppercase tracking-wide">Invoice Information</h3>
                        <div class="bg-background rounded-lg border border-neutral/20 divide-y divide-neutral/10">
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-sm text-base/60">Invoice Number</span>
                                <span class="font-medium">{{ $invoice->number }}</span>
                            </div>
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-sm text-base/60">Invoice Date</span>
                                <span class="font-medium">{{ $invoice->created_at->format('d M Y') }}</span>
                            </div>
                            @if ($invoice->due_at)
                                <div class="flex justify-between items-center px-4 py-3">
                                    <span class="text-sm text-base/60">Due Date</span>
                                    <span class="font-medium">{{ $invoice->due_at->format('d M Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-base/70 uppercase tracking-wide">Payment Options</h3>
                        <div class="bg-background rounded-lg border border-neutral/20 p-4 space-y-4">
                            @if (
                                $checkPayment ||
                                    $invoice->transactions->where('status', \App\Enums\InvoiceTransactionStatus::Processing)->where('created_at', '>=', now()->subDay())->count() > 0)
                                <div
                                    class="flex items-center gap-3 p-3 rounded-lg bg-warning/10 border border-warning/20">
                                    <x-ri-time-line class="size-5 text-warning" />
                                    <div>
                                        <p class="text-sm font-medium text-warning">Payment Processing</p>
                                        <p class="text-xs text-base/60">We are still processing your last payment.
                                            Please check back shortly.</p>
                                    </div>
                                </div>
                                <x-button.primary wire:click="checkPaymentStatus" wire:loading.attr="disabled"
                                    class="w-full justify-center py-2.5" wire:target="checkPaymentStatus">
                                    <span wire:loading wire:target="checkPaymentStatus">
                                        <x-ri-loader-5-fill class="size-5 mr-2 animate-spin" />
                                        Checking...
                                    </span>
                                    <span wire:loading.remove wire:target="checkPaymentStatus">Check Payment
                                        Status</span>
                                </x-button.primary>
                            @else
                                @php
                                    $credit = Auth::user()
                                        ->credits()
                                        ->where('currency_code', $invoice->currency_code)
                                        ->where('amount', '>', 0)
                                        ->first();
                                    $itemHasCredit = $invoice
                                        ->items()
                                        ->where('reference_type', App\Models\Credit::class)
                                        ->exists();
                                    $availableGateways = $gateways ?? [];
                                @endphp

                                @if ($credit && !$itemHasCredit)
                                    <div class="p-3 rounded-lg bg-neutral/5 border border-neutral/10">
                                        <x-form.checkbox wire:model="use_credits" name="use_credits"
                                            label="Use available credits ({{ $credit->formattedAmount }})" />
                                    </div>
                                @endif

                                @if (count($availableGateways) > 1)
                                    <div>
                                        <x-form.select wire:model.live="gateway" label="Payment Method" name="gateway">
                                            @foreach ($availableGateways as $gateway)
                                                <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </div>
                                @endif

                                <x-button.primary wire:click="$set('showPayModal', true)" wire:loading.attr="disabled"
                                    wire:target="$set('showPayModal')" class="w-full justify-center py-3">
                                    <div class="flex items-center">
                                        <span wire:loading wire:target="pay">
                                            <x-ri-loader-5-fill class="size-5 mr-2 animate-spin" />
                                            Processing...
                                        </span>
                                        <span wire:loading.remove wire:target="pay">
                                            <x-ri-bank-card-fill class="size-5 mr-2" />
                                            Pay {{ $invoice->formattedRemaining }}
                                        </span>
                                    </div>
                                </x-button.primary>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-base/70 uppercase tracking-wide mb-3">Invoice Items</h3>
                        <div class="bg-background rounded-xl border border-neutral/20 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-neutral/5 border-b border-neutral/10 text-base/60">
                                        <tr>
                                            <th class="p-3 text-left">Item</th>
                                            <th class="p-3 text-left">Price</th>
                                            <th class="p-3 text-left">Quantity</th>
                                            <th class="p-3 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral/10">
                                        @foreach ($invoice->items as $item)
                                            <tr class="hover:bg-neutral/5 transition-colors">
                                                <td class="p-3 font-medium">
                                                    @if (in_array($item->reference_type, ['App\Models\Service', 'App\Models\ServiceUpgrade']))
                                                        <a href="{{ route('services.show', $item->reference_type == 'App\Models\Service' ? $item->reference_id : $item->reference->service_id) }}"
                                                            class="text-primary hover:text-primary/80 transition-colors">
                                                            {{ $item->description }}
                                                        </a>
                                                    @else
                                                        {{ $item->description }}
                                                    @endif
                                                </td>
                                                <td class="p-3 text-base/70">{{ $item->formattedPrice }}</td>
                                                <td class="p-3 text-base/70">{{ $item->quantity }}</td>
                                                <td class="p-3 text-right font-semibold">{{ $item->formattedTotal }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-full md:w-72">
                            <h3 class="text-sm font-medium text-base/70 uppercase tracking-wide mb-3">Invoice Summary
                            </h3>
                            <div
                                class="bg-background rounded-xl border border-neutral/20 overflow-hidden divide-y divide-neutral/10">
                                @if ($invoice->formattedTotal->tax > 0)
                                    <div class="flex justify-between px-4 py-3">
                                        <span class="text-sm text-base/60">Subtotal</span>
                                        <span
                                            class="font-medium">{{ $invoice->formattedTotal->format($invoice->formattedTotal->price - $invoice->formattedTotal->tax) }}</span>
                                    </div>
                                    <div class="flex justify-between px-4 py-3">
                                        <span class="text-sm text-base/60">{{ \App\Classes\Settings::tax()->name }}
                                            ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                                        <span class="font-medium">{{ $invoice->formattedTotal->formatted->tax }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between px-4 py-3 bg-neutral/5">
                                    <span class="font-semibold">Total</span>
                                    <span class="font-bold text-primary">{{ $invoice->formattedTotal }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($invoice->transactions->isNotEmpty())
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-base/70 uppercase tracking-wide">Transaction History
                            </h3>
                            <span class="text-xs text-base/60">{{ $invoice->transactions->count() }} records</span>
                        </div>
                        <div class="bg-background rounded-xl border border-neutral/20 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-neutral/5 border-b border-neutral/10 text-base/60">
                                        <tr>
                                            <th class="p-3 text-left">Date</th>
                                            <th class="p-3 text-left">Transaction ID</th>
                                            <th class="p-3 text-left">Payment Method</th>
                                            <th class="p-3 text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral/10">
                                        @foreach ($invoice->transactions as $transaction)
                                            <tr class="hover:bg-neutral/5 transition-colors">
                                                <td class="p-3 text-base/70">
                                                    <div class="flex items-center">
                                                        <div class="bg-neutral/10 rounded-full p-1 mr-2">
                                                            <x-ri-time-line class="size-3.5 text-base/60" />
                                                        </div>
                                                        {{ $transaction->created_at->format('d M Y H:i') }}
                                                    </div>
                                                </td>
                                                <td class="p-3 font-medium">{{ $transaction->transaction_id }}</td>
                                                <td class="p-3 text-base/70">
                                                    @if ($transaction->is_credit_transaction)
                                                        {{ __('invoices.paid_with_credits') }}
                                                    @else
                                                        {{ $transaction->gateway?->name }}
                                                    @endif
                                                </td>
                                                <td class="p-3 text-right font-semibold text-primary">
                                                    {{ $transaction->formattedAmount }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
