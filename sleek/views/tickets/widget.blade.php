<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">Recent Tickets</h2>
        <a href="{{ route('tickets') }}"
            class="text-sm text-primary hover:text-primary/80 transition-colors duration-200 flex items-center gap-1">
            View All
            <x-ri-arrow-right-line class="size-4" />
        </a>
    </div>

    <div class="space-y-3">
        @if (count($tickets) > 0)
            @foreach ($tickets as $ticket)
                <a href="{{ route('tickets.show', $ticket) }}" class="block group" wire:navigate>
                    <div
                        class="bg-background-secondary border border-neutral/20 hover:border-neutral/30 p-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="bg-neutral/10 p-2.5 rounded-lg group-hover:bg-primary/10 transition-colors">
                                    <x-ri-ticket-line
                                        class="size-5 text-base/80 group-hover:text-primary transition-colors" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="font-semibold text-base group-hover:text-primary transition-colors truncate">
                                        {{ $ticket->subject }}</h3>
                                    <p class="text-xs text-base/60">{{ $ticket->department ?: 'General' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full border
                                    {{ $ticket->status == 'open'
                                        ? 'bg-success/10 text-success border-success/20'
                                        : ($ticket->status == 'closed'
                                            ? 'bg-error/10 text-error border-error/20'
                                            : 'bg-info/10 text-info border-info/20') }}">
                                    @if ($ticket->status == 'open')
                                        <x-ri-checkbox-circle-fill class="mr-1 size-3" /> Open
                                    @elseif($ticket->status == 'closed')
                                        <x-ri-close-circle-fill class="mr-1 size-3" /> Closed
                                    @elseif($ticket->status == 'replied')
                                        <x-ri-chat-smile-2-fill class="mr-1 size-3" /> Replied
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="text-sm text-base/70 border-t border-neutral/10 pt-2 mt-2">
                            <p class="flex items-center gap-2">
                                <x-ri-time-line class="size-3.5 text-primary/70" />
                                {{ $ticket->messages()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="bg-background-secondary border border-neutral/20 p-6 rounded-xl text-center">
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="bg-neutral/5 rounded-full p-4 mb-1">
                        <x-ri-ticket-line class="size-6 text-base/50" />
                    </div>
                    <p class="font-medium">No open tickets</p>
                    <p class="text-xs text-base/60">All your support requests are resolved</p>
                    <a href="{{ route('tickets.create') }}"
                        class="mt-2 text-sm text-primary hover:text-primary/80 transition-colors duration-200 flex items-center gap-1">
                        <x-ri-add-line class="size-4" />
                        Create New Ticket
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
