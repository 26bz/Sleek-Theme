<div class="max-w-screen-xl mx-auto">
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-2xl font-bold">{{ __('ticket.create_ticket') }}</h1>
        <a href="{{ route('tickets') }}"
            class="flex items-center gap-2 px-3 py-1.5 text-sm bg-background-secondary hover:bg-neutral/20 border border-neutral/20 text-base rounded-md transition-colors"
            wire:navigate>
            <x-ri-arrow-left-line class="size-4" />
            <span>{{ __('Back to Tickets') }}</span>
        </a>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden">
        <div class="border-b border-neutral/20 p-4">
            <h2 class="font-medium">{{ __('New Support Ticket') }}</h2>
            <p class="text-sm text-base/60 mt-1">{{ __('Please provide details about your issue') }}</p>
        </div>

        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form.input wire:model="subject" label="{{ __('ticket.subject') }}" name="subject" required />

                @if (count($departments) > 0)
                    <x-form.select wire:model="department" label="{{ __('ticket.department') }}" name="department"
                        required>
                        <option value="">{{ __('ticket.select_department') }}</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department }}">{{ $department }}</option>
                        @endforeach
                    </x-form.select>
                @endif

                <x-form.select wire:model="priority" label="{{ __('ticket.priority') }}" name="priority" required>
                    <option value="">{{ __('ticket.select_priority') }}</option>
                    <option value="low" selected>{{ __('ticket.low') }}</option>
                    <option value="medium">{{ __('ticket.medium') }}</option>
                    <option value="high">{{ __('ticket.high') }}</option>
                </x-form.select>

                <x-form.select wire:model="service" label="{{ __('ticket.service') }}" name="service">
                    <option value="">{{ __('ticket.select_service') }}</option>
                    @foreach ($services as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->product->name }} ({{ ucfirst($product->status) }})
                            @if ($product->expires_at)
                                - {{ $product->expires_at->format('Y-m-d') }}
                            @endif
                        </option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="mt-5">
                <form wire:submit.prevent="create" wire:ignore>
                    <label for="editor" class="block text-sm font-medium mb-2">
                        {{ __('Message') }} <span class="text-error">*</span>
                    </label>
                    <div class="editor-container border border-neutral/20 rounded-md">
                        <textarea id="editor" placeholder="Describe your issue in detail..." class="resize-y"></textarea>
                    </div>

                    <div class="mt-4">
                        <label for="attachments" class="block text-sm font-medium mb-2">
                            {{ __('ticket.attachments') }}
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
                            <div class="flex justify-center rounded-lg border border-dashed border-neutral/30 px-4 py-3"
                                @dragover.prevent="drop = true" @dragleave.prevent="drop = false"
                                @drop.prevent="handleDrop($event)" :class="{ 'bg-primary/5': drop }">
                                <div class="text-center">
                                    <template x-if="selectedFiles.length === 0">
                                        <div>
                                            <x-ri-upload-cloud-2-line class="mx-auto size-8 text-base/40 mb-2" />
                                            <div
                                                class="flex flex-col sm:flex-row items-center justify-center gap-1 text-sm">
                                                <label for="attachments"
                                                    class="cursor-pointer font-medium text-primary hover:text-primary/80 transition-colors">
                                                    <span>{{ __('ticket.upload_attachments') }}</span>
                                                </label>
                                                <p class="text-base/60">{{ __('ticket.or_drag_and_drop') }}</p>
                                            </div>
                                            <p class="text-xs text-base/50 mt-1">{{ __('ticket.files_max') }}</p>
                                        </div>
                                    </template>
                                    <div x-show="selectedFiles.length > 0">
                                        <h4 class="text-sm font-medium mb-2">{{ __('ticket.selected_files') }}:</h4>
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            <template x-for="file in selectedFiles" :key="file.name">
                                                <div
                                                    class="text-sm rounded-md bg-background border border-neutral/20 flex items-center gap-2 px-2 py-1 w-fit">
                                                    <x-ri-file-line class="size-4 text-base/60" />
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

                    <div class="mt-5 flex justify-end">
                        <x-button.primary type="submit" class="px-6">
                            {{ __('ticket.create') }}
                        </x-button.primary>
                    </div>
                </form>
                <x-easymde-editor />
            </div>
        </div>
    </div>
</div>
