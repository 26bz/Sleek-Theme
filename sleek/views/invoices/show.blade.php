<div class="space-y-6" @if ($checkPayment) wire:poll="checkPaymentStatus" @endif>
    <x-navigation.breadcrumb />

    @if ($this->pay)
        <x-modal title="Payment for Invoice #{{ $invoice->number }}" open>
            <div class="mt-6">
                {{ $this->pay }}
            </div>
            <x-slot name="closeTrigger">
                <div class="flex items-center gap-4">
                    <span class="font-medium">Amount: <span
                            class="text-primary">{{ $invoice->formattedRemaining }}</span></span>
                    <button wire:confirm="Are you sure you want to cancel this payment?" wire:click="exitPay"
                        @click="open = false" class="text-base/70 hover:text-base transition-colors duration-200">
                        <x-ri-close-fill class="size-6" />
                    </button>
                </div>
            </x-slot>
        </x-modal>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-2">
        <h1 class="text-2xl font-bold">Invoice #{{ $invoice->number }}</h1>

        <x-button.link wire:click="downloadPDF" class="flex items-center gap-2">
            <span wire:loading wire:target="downloadPDF">
                <x-ri-loader-5-fill class="size-5 animate-spin" />
            </span>
            <span wire:loading.remove wire:target="downloadPDF">
                <x-ri-download-line class="size-5" />
            </span>
            <span>Download PDF</span>
        </x-button.link>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
        <div class="border-b border-neutral/20 p-4 flex justify-between items-center">
            <h2 class="font-medium">Invoice Details</h2>
            @if ($invoice->status == 'paid')
                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5 text-success">
                    <x-ri-checkbox-circle-fill class="mr-1.5 size-3.5" /> Paid
                </span>
            @elseif($invoice->status == 'cancelled')
                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5 text-error">
                    <x-ri-close-circle-fill class="mr-1.5 size-3.5" /> Cancelled
                </span>
            @elseif($invoice->status == 'pending')
                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5 text-warning">
                    <x-ri-error-warning-fill class="mr-1.5 size-3.5" /> Pending
                </span>
            @endif
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-sm font-medium mb-3">Issued To</h3>
                    <div class="bg-background rounded-lg border border-neutral/20 p-4">
                        <p class="font-medium">{{ $invoice->user->name }}</p>
                        @foreach ($invoice->user->properties()->with('parent_property')->whereHas('parent_property', function ($query) {
            $query->where('show_on_invoice', true);
        })->get() as $property)
                            <p class="text-sm text-base/70 mt-1">{{ $property->value }}</p>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium mb-3">Bill From</h3>
                    <div class="bg-background rounded-lg border border-neutral/20 p-4">
                        <div class="text-sm text-base/70">
                            {!! nl2br(e(config('settings.bill_to_text', config('settings.company_name')))) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-sm font-medium mb-3">Invoice Information</h3>
                    <div class="bg-background rounded-lg border border-neutral/20 divide-y divide-neutral/10">
                        <div class="flex justify-between py-3 px-4">
                            <span class="text-sm text-base/70">Invoice Number</span>
                            <span class="font-medium">{{ $invoice->number }}</span>
                        </div>
                        <div class="flex justify-between py-3 px-4">
                            <span class="text-sm text-base/70">Invoice Date</span>
                            <span class="font-medium">{{ $invoice->created_at->format('d M Y') }}</span>
                        </div>
                        @if ($invoice->due_at)
                            <div class="flex justify-between py-3 px-4">
                                <span class="text-sm text-base/70">Due Date</span>
                                <span class="font-medium">{{ $invoice->due_at->format('d M Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($invoice->status == 'pending')
                    <div>
                        <h3 class="text-sm font-medium mb-3">Payment Options</h3>
                        <div class="bg-background rounded-lg border border-neutral/20 p-4">
                            @if ($checkPayment)
                                <div
                                    class="flex items-center gap-2 mb-4 p-3 rounded-lg bg-neutral/5 border border-neutral/10">
                                    <x-ri-time-line class="size-5 text-warning" />
                                    <span>Payment is being processed</span>
                                </div>
                                <x-button.primary wire:click="checkPaymentStatus" wire:loading.attr="disabled"
                                    class="flex items-center justify-center w-full mb-4 py-2.5"
                                    wire:target="checkPaymentStatus">
                                    <span wire:loading wire:target="checkPaymentStatus">
                                        <x-ri-loader-5-fill class="size-5 mr-2 animate-spin" />
                                        Checking payment status...
                                    </span>
                                    <span wire:loading.remove wire:target="checkPaymentStatus">
                                        Check Payment Status
                                    </span>
                                </x-button.primary>
                            @endif

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
                            @endphp
                            @if ($credit && !$itemHasCredit)
                                <div class="mb-4 p-3 rounded-lg bg-neutral/5 border border-neutral/10">
                                    <x-form.checkbox wire:model="use_credits" name="use_credits"
                                        label="Use available credits" />
                                </div>
                            @endif

                            @if (count($gateways) > 1)
                                <div class="mb-4">
                                    <x-form.select wire:model.live="gateway" label="Payment Method" name="gateway">
                                        @foreach ($gateways as $gateway)
                                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            @endif

                            <x-button.primary wire:click="pay" wire:loading.attr="disabled" wire:target="pay"
                                class="w-full justify-center py-3">
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
                        </div>
                    </div>
                @endif
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-medium mb-3">Invoice Items</h3>
                <div class="bg-background rounded-lg border border-neutral/20 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-neutral/5 border-b border-neutral/10">
                                    <th class="p-3 text-xs font-medium text-left">
                                        Item
                                    </th>
                                    <th class="p-3 text-xs font-medium text-left">
                                        Price
                                    </th>
                                    <th class="p-3 text-xs font-medium text-left">
                                        Quantity
                                    </th>
                                    <th class="p-3 text-xs font-medium text-right">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral/10">
                                @foreach ($invoice->items as $item)
                                    <tr class="hover:bg-neutral/5 transition-colors duration-150">
                                        <td class="p-3 font-medium">
                                            @if (in_array($item->reference_type, ['App\Models\Service', 'App\Models\ServiceUpgrade']))
                                                <a href="{{ route('services.show', $item->reference_type == 'App\Models\Service' ? $item->reference_id : $item->reference->service_id) }}"
                                                    class="text-primary hover:text-primary/80 transition-colors duration-200">
                                                    {{ $item->description }}
                                                </a>
                                            @else
                                                {{ $item->description }}
                                            @endif
                                        </td>
                                        <td class="p-3 text-base/70">{{ $item->formattedPrice }}</td>
                                        <td class="p-3 text-base/70">{{ $item->quantity }}</td>
                                        <td class="p-3 font-medium text-right">{{ $item->formattedTotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mb-6">
                <div class="w-full md:w-72">
                    <h3 class="text-sm font-medium mb-3">Invoice Summary</h3>
                    <div
                        class="bg-background rounded-lg border border-neutral/20 divide-y divide-neutral/10 overflow-hidden">
                        @if ($invoice->formattedTotal->tax > 0)
                            <div class="flex justify-between py-3 px-4">
                                <span class="text-sm text-base/70">Subtotal</span>
                                <span
                                    class="font-medium">{{ $invoice->formattedTotal->format($invoice->formattedTotal->price - $invoice->formattedTotal->tax) }}</span>
                            </div>
                            <div class="flex justify-between py-3 px-4">
                                <span class="text-sm text-base/70">{{ \App\Classes\Settings::tax()->name }}
                                    ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                                <span class="font-medium">{{ $invoice->formattedTotal->formatted->tax }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-3 px-4 bg-neutral/5">
                            <span class="font-semibold">Total</span>
                            <span class="font-bold text-primary">{{ $invoice->formattedTotal }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($invoice->transactions->isNotEmpty())
                <div class="mt-6">
                    <h3 class="text-sm font-medium mb-3">Transaction History</h3>
                    <div class="bg-background rounded-lg border border-neutral/20 overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-neutral/5 border-b border-neutral/10">
                                        <th class="p-3 text-xs font-medium text-left">
                                            Date
                                        </th>
                                        <th class="p-3 text-xs font-medium text-left">
                                            Transaction ID
                                        </th>
                                        <th class="p-3 text-xs font-medium text-left">
                                            Payment Method
                                        </th>
                                        <th class="p-3 text-xs font-medium text-right">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral/10">
                                    @foreach ($invoice->transactions as $transaction)
                                        <tr class="hover:bg-neutral/5 transition-colors duration-150">
                                            <td class="p-3 text-base/70">
                                                <div class="flex items-center">
                                                    <div class="bg-neutral/5 rounded-full p-1 mr-2">
                                                        <x-ri-time-line class="size-3.5 text-base/60" />
                                                    </div>
                                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                                </div>
                                            </td>
                                            <td class="p-3">
                                                <span class="font-medium">{{ $transaction->transaction_id }}</span>
                                            </td>
                                            <td class="p-3 text-base/70">
                                                {{ $transaction->gateway?->name }}
                                            </td>
                                            <td class="p-3 text-right">
                                                <span
                                                    class="font-medium text-primary">{{ $transaction->formattedAmount }}</span>
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
