<div class="space-y-6">
    <x-navigation.breadcrumb />

    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('tickets') }}" class="text-base/70 hover:text-primary transition-colors" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">{{ $ticket->subject }}</h1>
            </div>
            <p class="text-sm text-base/60 mt-1">Ticket #{{ $ticket->id }} ·
                {{ $ticket->created_at->format('M d, Y') }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($ticket->status == 'open')
                <span
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 size-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z" />
                    </svg> Open
                </span>
            @elseif($ticket->status == 'closed')
                <span
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 size-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-11.414L9.172 7.757 7.757 9.172 10.586 12l-2.829 2.828 1.415 1.415L12 13.414l2.828 2.829 1.415-1.415L13.414 12l2.829-2.828-1.415-1.415L12 10.586z" />
                    </svg> Closed
                </span>
            @elseif($ticket->status == 'replied')
                <span
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 size-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-6c-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4s4-1.79 4-4h2c0 3.314-2.686 6-6 6zm-3-8.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm6 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg> Replied
                </span>
            @endif

            <span
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-base/70">
                @if ($ticket->priority == 'high')
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 size-4 text-error" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12.866 3l9.526 16.5a1 1 0 01-.866 1.5H2.474a1 1 0 01-.866-1.5L11.134 3a1 1 0 011.732 0zM11 16v2h2v-2h-2zm0-7v5h2V9h-2z" />
                    </svg>
                @elseif($ticket->priority == 'medium')
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 size-4 text-warning" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm3.536 5.05L10.586 12 12 13.414l4.95-4.95-1.414-1.414z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 size-4 text-info" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm1-10V7h-2v7h6v-2h-4z" />
                    </svg>
                @endif
                {{ ucfirst($ticket->priority) }} Priority
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:order-last order-first">
            <div
                class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden sticky top-4">
                <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                    <h2 class="font-medium">Ticket Details</h2>
                </div>

                <div class="divide-y divide-neutral/10">
                    <div class="p-4">
                        <h4 class="text-xs font-medium text-base/60 uppercase mb-1">Subject</h4>
                        <p class="font-medium">{{ $ticket->subject }}</p>
                    </div>

                    <div class="p-4">
                        <h4 class="text-xs font-medium text-base/60 uppercase mb-1">Status</h4>
                        <div class="flex items-center gap-2">
                            @if ($ticket->status == 'open')
                                <span
                                    class="inline-block w-2 h-2 rounded-full text-success bg-current opacity-90"></span>
                                <p class="font-medium text-success">Open</p>
                            @elseif($ticket->status == 'closed')
                                <span class="inline-block w-2 h-2 rounded-full text-error bg-current opacity-90"></span>
                                <p class="font-medium text-error">Closed</p>
                            @else
                                <span class="inline-block w-2 h-2 rounded-full text-info bg-current opacity-90"></span>
                                <p class="font-medium text-info">Replied</p>
                            @endif
                        </div>
                    </div>

                    <div class="p-4">
                        <h4 class="text-xs font-medium text-base/60 uppercase mb-1">Priority</h4>
                        <div class="flex items-center gap-2">
                            @if ($ticket->priority == 'high')
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-error" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12.866 3l9.526 16.5a1 1 0 01-.866 1.5H2.474a1 1 0 01-.866-1.5L11.134 3a1 1 0 011.732 0zM11 16v2h2v-2h-2zm0-7v5h2V9h-2z" />
                                </svg>
                            @elseif($ticket->priority == 'medium')
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-warning" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm3.536 5.05L10.586 12 12 13.414l4.95-4.95-1.414-1.414z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-info" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm1-10V7h-2v7h6v-2h-4z" />
                                </svg>
                            @endif
                            <p class="font-medium">{{ ucfirst($ticket->priority) }}</p>
                        </div>
                    </div>

                    <div class="p-4">
                        <h4 class="text-xs font-medium text-base/60 uppercase mb-1">Created</h4>
                        <p class="font-medium">{{ $ticket->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    @if ($ticket->department)
                        <div class="p-4">
                            <h4 class="text-xs font-medium text-base/60 uppercase mb-1">Department</h4>
                            <p class="font-medium">{{ $ticket->department }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            <div class="bg-background-secondary border border-neutral/20 rounded-lg shadow-sm overflow-hidden">
                <div class="border-b border-neutral/20 p-4 flex items-center justify-between">
                    <h2 class="font-medium">Conversation History</h2>
                    <span class="text-xs text-base/60">{{ $ticket->messages->count() }} messages</span>
                </div>

                <div class="p-4">
                    <div class="flex flex-col gap-4 max-h-[60vh] overflow-y-auto pr-2" wire:poll.10s>
                        @foreach ($ticket->messages()->with('user')->get() as $message)
                            <div
                                class="flex flex-row items-start gap-3 {{ $message->user_id === $ticket->user_id ? 'flex-row-reverse' : '' }}">
                                <div class="flex-shrink-0">
                                    <div
                                        class="size-10 rounded-full {{ $message->user_id === $ticket->user_id ? 'bg-primary/10 text-primary' : 'bg-neutral/10 text-base/70' }} flex items-center justify-center font-medium">
                                        {{ substr($message->user->name, 0, 1) }}
                                    </div>
                                </div>

                                <div
                                    class="flex-grow max-w-[85%] bg-background border border-neutral/20 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-medium">{{ $message->user->name }}</h3>

                                                @if ($message->user_id !== $ticket->user_id)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-neutral/5 text-primary border border-neutral/10">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 size-3"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M21 8a2 2 0 012 2v4a2 2 0 01-2 2h-1.062A8.001 8.001 0 0112 23v-2a6 6 0 006-6V9A6 6 0 106 9v7H3a2 2 0 01-2-2v-4a2 2 0 012-2h1.062a8.001 8.001 0 0115.876 0H21zM7.76 15.785l1.06-1.696A5.972 5.972 0 0012 15a5.972 5.972 0 003.18-.911l1.06 1.696A7.963 7.963 0 0112 17a7.963 7.963 0 01-4.24-1.215z" />
                                                        </svg> Staff
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-base/60">
                                                {{ $message->created_at->format('M d, Y H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="prose dark:prose-invert prose-sm max-w-none break-words mt-3">
                                        {!! Str::markdown($message->message, [
                                            'html_input' => 'escape',
                                            'allow_unsafe_links' => false,
                                            'renderer' => [
                                                'soft_break' => '<br>',
                                            ],
                                        ]) !!}
                                    </div>

                                    @if (count($message->attachments) > 0)
                                        <div class="mt-4 pt-3 border-t border-neutral/10">
                                            <h4 class="text-xs font-medium text-base/60 mb-2">Attachments</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($message->attachments as $attachment)
                                                    <a href="{{ route('tickets.attachments.show', $attachment) }}"
                                                        class="text-sm rounded-lg bg-neutral/5 border border-neutral/10 flex items-center gap-2 px-2.5 py-1 hover:bg-neutral/10 transition-colors">
                                                        @if ($attachment->canPreview())
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="size-4 text-primary" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="size-4 text-primary" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        @endif
                                                        <span>{{ $attachment->filename }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($loop->last)
                                <div x-data x-init="$nextTick(() => $el.scrollIntoView({ block: 'end' }))"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
                <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                    <h2 class="font-medium">Reply to Ticket</h2>
                </div>

                <div class="p-6">
                    <form wire:submit.prevent="save" wire:ignore>
                        <div class="editor-container border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
                            <textarea id="editor" placeholder="Type your reply here..."></textarea>
                        </div>

                        <div class="mt-5">
                            <label for="attachments" class="block text-sm font-medium mb-2">
                                Attachments
                            </label>
                            <div x-data="{
                                drop: false,
                                selectedFiles: [],
                                handleDrop(event) {
                                    this.drop = false;
                                    if (event.dataTransfer.files && event.dataTransfer.files.length > 0) {
                                        this.selectedFiles = Array.from(event.dataTransfer.files);
                                        this.$refs.fileInput.files = event.dataTransfer.files;
                                        this.$refs.fileInput.dispatchEvent(new Event('change'));
                                    }
                                },
                                init() {
                                    this.$watch('$wire.attachments', (value) => {
                                        if (value.length == 0) {
                                            this.selectedFiles = [];
                                        }
                                    });
                                }
                            }" class="max-h-[150px] overflow-y-auto">
                                <div class="flex justify-center rounded-lg border border-dashed border-neutral/30 px-6 py-4"
                                    @dragover.prevent="drop = true" @dragleave.prevent="drop = false"
                                    @drop.prevent="handleDrop($event)" :class="{ 'bg-primary/5': drop }">
                                    <div class="text-center">
                                        <template x-if="selectedFiles.length === 0">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="mx-auto size-10 text-base/40 mb-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <div
                                                    class="flex flex-col sm:flex-row items-center justify-center gap-1 text-sm">
                                                    <label for="attachments"
                                                        class="cursor-pointer font-medium text-primary hover:text-primary/80 transition-colors">
                                                        <span>Upload files</span>
                                                    </label>
                                                    <p class="text-base/60">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-base/50 mt-1">Max 10MB per file</p>
                                            </div>
                                        </template>
                                        <div x-show="selectedFiles.length > 0">
                                            <h4 class="text-sm font-medium mb-2">Selected files:</h4>
                                            <div class="flex flex-wrap items-center justify-center gap-2">
                                                <template x-for="file in selectedFiles" :key="file.name">
                                                    <div
                                                        class="text-sm rounded-lg bg-background border border-neutral/20 flex items-center gap-2 px-3 py-1.5 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="size-4 text-primary/70" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <span class="flex-1" x-text="file.name"></span>
                                                        <button type="button"
                                                            class="text-base/60 hover:text-error transition-colors"
                                                            @click="selectedFiles = selectedFiles.filter(f => f !== file)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input id="attachments" type="file" multiple name="attachments[]" class="sr-only"
                                    wire:model.live="attachments" x-ref="fileInput"
                                    @change="selectedFiles = Array.from($event.target.files)" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-button.primary type="submit" class="px-6 py-2.5 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z" />
                                </svg>
                                Send Reply
                            </x-button.primary>
                        </div>
                    </form>
                    <x-easymde-editor />
                </div>
            </div>
        </div>
    </div>
</div>
