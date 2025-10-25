@if ($announcements->count() > 0)
    <div
        class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral/20 bg-neutral/5">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-neutral/10 rounded-lg">
                    <x-ri-megaphone-fill class="size-4 text-base/80" />
                </div>
                <h2 class="font-semibold text-base">{{ __('Announcements') }}</h2>
            </div>

            <x-navigation.link
                class="text-xs font-medium text-primary hover:text-primary/80 flex items-center gap-1 px-2 py-1 rounded hover:bg-primary/5 transition-colors"
                :href="route('announcements.index')">
                {{ __('dashboard.view_all') }}
                <x-ri-arrow-right-s-line class="size-3.5" />
            </x-navigation.link>
        </div>

        <div class="p-5 space-y-4">
            @foreach ($announcements as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}"
                    class="block group bg-background-secondary border border-neutral/20 rounded-xl p-5 hover:border-neutral/30 transition-all duration-200 hover:shadow-sm"
                    wire:navigate>
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-secondary/10 p-2.5 rounded-lg">
                                <x-ri-newspaper-line class="size-5 text-secondary" />
                            </div>
                            <span class="font-semibold text-base group-hover:text-primary transition-colors">
                                {{ $announcement->title }}
                            </span>
                        </div>
                        <span class="text-xs font-medium text-base/60">
                            {{ optional($announcement->published_at)->diffForHumans() }}
                        </span>
                    </div>

                    @if ($announcement->description)
                        <p class="text-sm text-base/70">
                            {{ $announcement->description }}
                        </p>
                    @endif

                    <div class="mt-4 flex items-center gap-2 text-xs font-medium text-primary">
                        <span>{{ __('general.view') }}</span>
                        <x-ri-arrow-right-s-line class="size-4 transition-transform group-hover:translate-x-1" />
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
