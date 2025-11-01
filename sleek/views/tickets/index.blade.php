<div class="space-y-6 pt-4">
    <x-navigation.breadcrumb />

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold">Support Tickets</h1>
        <a href="{{ route('tickets.create') }}" wire:navigate>
            <x-button.primary
                class="flex items-center justify-center gap-2 py-2.5 px-4 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20">
                <x-ri-add-line class="size-5" />
                <span>Create New Ticket</span>
            </x-button.primary>
        </a>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
        @if (count($tickets) > 0)
            <div
                class="border-b border-neutral/10 p-4 flex items-center justify-between text-sm text-base/60 font-medium bg-neutral/5">
                <div class="w-1/2 px-2">Subject</div>
                <div class="w-1/4 text-center hidden md:block">Department</div>
                <div class="w-1/4 md:w-1/6 text-center">Status</div>
                <div class="w-1/4 md:w-1/6 text-right pr-2">Last Activity</div>
            </div>

            <div class="divide-y divide-neutral/10">
                @foreach ($tickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="block hover:bg-neutral/5 transition-colors"
                        wire:navigate>
                        <div class="p-4 flex items-center">
                            <div class="w-1/2 flex items-center gap-3 px-2">
                                <div
                                    class="bg-neutral/10 p-2.5 rounded-lg hidden sm:flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                    <x-ri-ticket-line
                                        class="size-5 text-base/80 group-hover:text-primary transition-colors" />
                                </div>
                                <div class="min-w-0">
                                    <span class="font-medium truncate block">#{{ $ticket->id }} · {{ $ticket->subject }}</span>
                                    <span
                                        class="text-xs text-base/60 md:hidden">{{ $ticket->department ?: 'General' }}</span>
                                </div>
                            </div>

                            <div class="w-1/4 text-center text-sm text-base/70 hidden md:block truncate">
                                {{ $ticket->department ?: 'General' }}
                            </div>

                            <div class="w-1/4 md:w-1/6 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full border
                                    {{ $ticket->status == 'open'
                                        ? 'bg-success/10 text-success border-success/20'
                                        : ($ticket->status == 'closed'
                                            ? 'bg-error/10 text-error border-error/20'
                                            : 'bg-info/10 text-info border-info/20') }}">
                                    @if ($ticket->status == 'open')
                                        <x-ri-checkbox-circle-fill class="mr-1.5 size-3.5" /> Open
                                    @elseif($ticket->status == 'closed')
                                        <x-ri-close-circle-fill class="mr-1.5 size-3.5" /> Closed
                                    @elseif($ticket->status == 'replied')
                                        <x-ri-chat-smile-2-fill class="mr-1.5 size-3.5" /> Replied
                                    @endif
                                </span>
                            </div>

                            <div class="w-1/4 md:w-1/6 text-right text-sm text-base/70 pr-2">
                                {{ $ticket->messages()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="p-10 text-center">
                <div class="bg-neutral/5 inline-flex p-5 rounded-full mb-4">
                    <x-ri-ticket-line class="size-10 text-base/50" />
                </div>
                <h3 class="text-xl font-semibold mb-2">No Support Tickets</h3>
                <p class="text-base/70 mb-6 max-w-md mx-auto">You haven't created any support tickets yet. Need help
                    with something? Create your first ticket.</p>
                <a href="{{ route('tickets.create') }}" class="inline-flex justify-center" wire:navigate>
                    <x-button.primary class="py-2.5 px-5">
                        <x-ri-add-line class="size-5" />
                        <span>Create New Ticket</span>
                    </x-button.primary>
                </a>
            </div>
        @endif
    </div>
</div>
