@if ($invoices->count() > 0)
    <div class="space-y-3">
        @foreach ($invoices as $invoice)
            <a href="{{ route('invoices.show', $invoice) }}" class="block group" wire:navigate>
                <div
                    class="bg-background border border-neutral/20 hover:border-neutral/30 p-4 rounded-xl transition-all duration-200 hover:shadow-sm group-hover:bg-background-secondary/30">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-neutral/10 p-2.5 rounded-lg group-hover:bg-primary/10 transition-colors">
                                <x-ri-bill-line class="size-5 text-base/80 group-hover:text-primary transition-colors" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-base group-hover:text-primary transition-colors">Invoice
                                    #{{ $invoice->number }}</h3>
                                <p class="text-xs text-base/60">{{ $invoice->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-base">{{ $invoice->formattedTotal }}</span>
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5
                            {{ $invoice->status == 'paid' ? 'text-success' : ($invoice->status == 'cancelled' ? 'text-error' : 'text-warning') }}">
                                @if ($invoice->status == 'paid')
                                    <x-ri-checkbox-circle-fill class="mr-1 size-3" /> Paid
                                @elseif($invoice->status == 'cancelled')
                                    <x-ri-forbid-fill class="mr-1 size-3" /> Cancelled
                                @elseif($invoice->status == 'pending')
                                    <x-ri-error-warning-fill class="mr-1 size-3" /> Pending
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="text-sm text-base/70 space-y-1">
                        @foreach ($invoice->items as $item)
                            <p class="flex items-center gap-2">
                                <x-ri-shopping-cart-line class="size-3.5 opacity-60 flex-shrink-0" />
                                <span class="truncate">{{ $item->description }}</span>
                            </p>
                        @endforeach
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@else
    <div class="bg-background-secondary border border-neutral/20 p-6 rounded-xl text-center">
        <div class="flex flex-col items-center justify-center gap-2">
            <div class="bg-neutral/5 rounded-full p-4 mb-1">
                <x-ri-bill-line class="size-6 text-base/50" />
            </div>
            <p class="font-medium">{{ __('No unpaid invoices') }}</p>
            <p class="text-xs text-base/60">{{ __('All of your invoices are settled. We will notify you when a new invoice is generated.') }}</p>
        </div>
    </div>
@endif

