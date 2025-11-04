<div class="container mt-14 space-y-4">
    <div class="flex flex-row justify-between">
        <x-navigation.breadcrumb />
        <a href="{{ route('tickets.create') }}" wire:navigate>
            <x-button.primary
                class="flex items-center justify-center gap-2 py-2.5 px-4 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20">
                <x-ri-add-line class="size-5" />
                <span>Create New Ticket</span>
            </x-button.primary>
        </a>
    </div>
    @forelse ($tickets as $ticket)
        <a href="{{ route('tickets.show', $ticket) }}" wire:navigate>
            <div class="bg-background-secondary hover:bg-background-secondary/80 border border-neutral/20 p-5 rounded-xl mb-4 transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="bg-secondary/10 p-2 rounded-lg">
                            <x-ri-ticket-line class="size-5 text-secondary" />
                        </div>
                        <span class="font-medium truncate max-w-[18rem]">#{{ $ticket->id }} - {{ $ticket->subject }}</span>
                    </div>
                    <div class="size-5 rounded-md p-0.5
                        @if ($ticket->status == 'open') text-success bg-success/20
                        @elseif($ticket->status == 'closed') text-inactive bg-inactive/20
                        @else text-info bg-info/20
                        @endif">
                        @if ($ticket->status == 'open')
                            <x-ri-checkbox-circle-fill />
                        @elseif($ticket->status == 'closed')
                            <x-ri-close-circle-fill />
                        @elseif($ticket->status == 'replied')
                            <x-ri-chat-smile-2-fill />
                        @endif
                    </div>
                </div>
                <p class="text-base text-sm text-base/70">
                    {{ $ticket->messages()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
                    {{ $ticket->department ? ' - ' . $ticket->department : '' }}
                </p>
            </div>
        </a>
    @empty
        <div class="bg-background-secondary border border-neutral/20 p-5 rounded-lg text-center">
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
    @endforelse

    {{ $tickets->links() }}
</div>
