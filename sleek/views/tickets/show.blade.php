<div class="space-y-6">
    <x-navigation.breadcrumb />

    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('tickets') }}" class="text-base/70 hover:text-primary transition-colors" wire:navigate>
                    <x-ri-arrow-left-line class="size-5" />
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
                    <x-ri-checkbox-circle-fill class="mr-1.5 size-4" /> Open
                </span>
            @elseif($ticket->status == 'closed')
                <span
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-error">
                    <x-ri-close-circle-fill class="mr-1.5 size-4" /> Closed
                </span>
            @elseif($ticket->status == 'replied')
                <span
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-info">
                    <x-ri-chat-smile-2-fill class="mr-1.5 size-4" /> Replied
                </span>
            @endif

            <span
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-neutral/20 bg-neutral/5 text-base/70">
                @if ($ticket->priority == 'high')
                    <x-ri-alarm-warning-fill class="mr-1.5 size-4 text-error" />
                @elseif($ticket->priority == 'medium')
                    <x-ri-timer-2-fill class="mr-1.5 size-4 text-warning" />
                @else
                    <x-ri-time-fill class="mr-1.5 size-4 text-info" />
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
                                <x-ri-alarm-warning-fill class="size-4 text-error" />
                            @elseif($ticket->priority == 'medium')
                                <x-ri-timer-2-fill class="size-4 text-warning" />
                            @else
                                <x-ri-time-fill class="size-4 text-info" />
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
                                                        <x-ri-customer-service-fill class="mr-1 size-3" /> Staff
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
                                                            <x-ri-image-line class="size-4 text-primary" />
                                                        @else
                                                            <x-ri-file-line class="size-4 text-primary" />
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
                                                <x-ri-upload-cloud-2-line class="mx-auto size-10 text-base/40 mb-3" />
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
                                                        <x-ri-file-line class="size-4 text-primary/70" />
                                                        <span class="flex-1" x-text="file.name"></span>
                                                        <button type="button"
                                                            class="text-base/60 hover:text-error transition-colors"
                                                            @click="selectedFiles = selectedFiles.filter(f => f !== file)">
                                                            <x-ri-close-line class="size-4" />
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
                                <x-ri-send-plane-fill class="size-4" />
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
