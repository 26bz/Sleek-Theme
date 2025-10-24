<div class="max-w-4xl mx-auto mt-16 px-6">
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-sm font-medium text-base/60 uppercase tracking-wide">
                {{ __('Announcements') }}
            </p>
            <h1 class="text-3xl md:text-4xl font-bold text-base mb-2">
                {{ $announcement->title }}
            </h1>
            @if ($announcement->published_at)
                <p class="text-sm text-base/60">
                    {{ $announcement->published_at->translatedFormat('F j, Y g:i A') }} · {{ $announcement->published_at->diffForHumans() }}
                </p>
            @endif
        </div>

        <x-navigation.link
            class="shrink-0 inline-flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80 px-3 py-2 rounded-lg bg-primary/5 hover:bg-primary/10 transition-colors"
            :href="route('announcements.index')"
        >
            <x-ri-arrow-left-s-line class="size-4" />
            {{ __('dashboard.view_all') }}
        </x-navigation.link>
    </div>

    <article
        class="bg-background-secondary border border-neutral/20 rounded-xl p-6 md:p-8 transition-all duration-200 hover:border-neutral/30 hover:shadow-sm">
        <div class="prose dark:prose-invert max-w-none leading-relaxed text-base/80">
            {!! $announcement->content !!}
        </div>
    </article>
</div>
