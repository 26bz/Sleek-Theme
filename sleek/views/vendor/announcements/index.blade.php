@if ($announcements->count() > 0)
    <section class="home-announcements mt-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-base mb-2">{{ __('Announcements') }}</h2>
                    <p class="text-base/70">
                        {{ __('Stay up to date with the latest news and updates from our team.') }}
                    </p>
                </div>
                @unless (request()->routeIs('announcements.index'))
                    <x-navigation.link
                        class="bg-background-secondary hover:bg-background-secondary/80 border border-neutral/20 flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium"
                        :href="route('announcements.index')">
                        {{ __('dashboard.view_all') }}
                        <x-ri-arrow-right-s-line class="size-5" />
                    </x-navigation.link>
                @endunless
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($announcements as $announcement)
                    <a href="{{ route('announcements.show', $announcement) }}"
                        class="group bg-background-secondary border border-neutral/20 rounded-xl hover:border-neutral/30 transition-all duration-200 hover:shadow-sm"
                        wire:navigate>
                        <div class="p-5 flex flex-col gap-4 h-full">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-secondary/10 p-2.5 rounded-lg">
                                        <x-ri-newspaper-line class="size-5 text-secondary" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold group-hover:text-primary transition-colors">
                                            {{ $announcement->title }}
                                        </h3>
                                        @if ($announcement->published_at)
                                            <p class="text-xs text-base/60">
                                                {{ $announcement->published_at->translatedFormat('M j, Y') }} ·
                                                {{ $announcement->published_at->diffForHumans() }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($announcement->description)
                                <p class="text-sm text-base/70 line-clamp-3">
                                    {{ $announcement->description }}
                                </p>
                            @endif

                            <div class="mt-auto flex items-center gap-2 text-xs font-medium text-primary">
                                <span>{{ __('general.view') }}</span>
                                <x-ri-arrow-right-s-line
                                    class="size-4 transition-transform group-hover:translate-x-1" />
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
