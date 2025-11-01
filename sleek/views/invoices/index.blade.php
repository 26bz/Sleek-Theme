<div class="space-y-6 pt-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">My Invoices</h1>
    </div>

    <div class="grid gap-4">
        @foreach ($invoices as $invoice)
            <a href="{{ route('invoices.show', $invoice) }}" class="block group" wire:navigate>
                <div
                    class="bg-background-secondary border border-neutral/20 hover:border-neutral/30 p-5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start md:items-center gap-4 flex-1 min-w-0">
                            <div
                                class="bg-neutral/5 p-3 rounded-lg border border-neutral/10 group-hover:border-neutral/20 transition-colors">
                                <x-ri-bill-line
                                    class="size-5 text-base/80 group-hover:text-primary transition-colors" />
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-lg group-hover:text-primary transition-colors">Invoice
                                    #{{ $invoice->number }}</h3>
                                <p class="text-sm text-base/60">{{ $invoice->created_at->format('M d, Y') }}</p>

                                @if ($invoice->items->count() > 0)
                                    <div class="mt-2 text-sm text-base/70 space-y-1">
                                        @foreach ($invoice->items->take(2) as $item)
                                            <p class="flex items-center gap-2 truncate">
                                                <x-ri-shopping-cart-line
                                                    class="size-3.5 text-primary/70 flex-shrink-0" />
                                                <span class="truncate">{{ $item->description }}</span>
                                            </p>
                                        @endforeach
                                        @if ($invoice->items->count() > 2)
                                            <p class="text-xs text-base/50 mt-1">and {{ $invoice->items->count() - 2 }}
                                                more items</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3 flex-shrink-0">
                            <div class="text-right">
                                <p class="text-sm text-base/60">Amount</p>
                                <p class="font-semibold text-primary">{{ $invoice->formattedTotal }}</p>
                            </div>

                            @if ($invoice->status == 'paid')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5 text-success">
                                    <x-ri-checkbox-circle-fill class="mr-1.5 size-3.5" /> Paid
                                </span>
                            @elseif($invoice->status == 'cancelled')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5 text-error">
                                    <x-ri-close-circle-fill class="mr-1.5 size-3.5" /> Cancelled
                                </span>
                            @elseif($invoice->status == 'pending')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border border-neutral/20 bg-neutral/5 text-warning">
                                    <x-ri-error-warning-fill class="mr-1.5 size-3.5" /> Pending
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @endforeach

        @if (count($invoices) === 0)
            <div class="bg-background-secondary border border-neutral/20 p-8 rounded-lg text-center shadow-sm">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="bg-neutral/5 rounded-full p-4 border border-neutral/10">
                        <x-ri-bill-line class="size-12 text-base/50" />
                    </div>
                    <h3 class="text-xl font-medium">No Invoices Found</h3>
                    <p class="text-base/70 max-w-md mx-auto">You don't have any invoices yet. They will appear here once
                        you make a purchase.</p>
                </div>
            </div>
        @endif
    </div>

    @if ($invoices->hasPages())
        <div class="mt-6">
            {{ $invoices->links() }}
        </div>
    @endif
</div>
