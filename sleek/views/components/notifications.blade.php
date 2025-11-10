<div>
    <x-dropdown width="w-84" :showArrow="false">
        <x-slot:trigger>
            <div class="relative w-10 h-10 flex items-center justify-center rounded-lg hover:bg-neutral transition" x-data="{ hasNew: false }" x-on:new-notification.window="hasNew = true"
                @click="hasNew = false">
                <x-ri-notification-3-fill class="size-4" ::class="{'animate-wiggle': hasNew}"/>
                @if($this->notifications->where('read_at', null)->count() > 0)
                <span
                    class="absolute top-0 right-0 w-4 h-4 inline-flex items-center justify-center text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                    {{ $this->notifications->where('read_at', null)->count() }}
                </span>
                @endif
            </div>
        </x-slot:trigger>
        <x-slot:content>
            <div class="w-full max-h-96 overflow-y-auto p-3 space-y-3">
                @if ($this->notifications->isEmpty())
                <div class="rounded-xl border border-neutral/20 bg-background-secondary p-4 text-center text-sm text-base/80">
                    {{ __('No new notifications') }}
                </div>
                @else
                @foreach ($this->notifications as $notification)
                <div wire:click="goToNotification('{{ $notification->id }}')"
                    class="group block cursor-pointer rounded-xl border border-neutral/20 bg-background-secondary p-4 transition-all duration-200 hover:border-neutral/30 hover:shadow-sm">
                    <div class="flex items-start gap-3">
                        <x-ri-notification-3-fill
                            class="size-5 mt-1 flex-shrink-0 {{ $notification->read_at ? 'text-base/80' : 'text-primary' }}" />
                        <div class="flex flex-col">
                            <span class="font-medium group-hover:text-primary transition-colors">{{ $notification->title }}</span>
                            <span class="text-sm text-base/80">{{ $notification->body }}</span>
                            <div class="flex flex-row justify-between mt-2 text-xs text-base/60">
                                <p>
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>

                                <button wire:click.stop="markAsRead('{{ $notification->id }}')" class="cursor-pointer text-primary/80 hover:text-primary transition-colors"
                                    type="button">
                                    {{ __('Mark as read') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </x-slot:content>
    </x-dropdown>
</div>