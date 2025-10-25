<div class="flex justify-center">
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex gap-2 items-center">
            <span>
                @if ($paginator->onFirstPage())
                    <span
                        class="bg-neutral/10 text-base/50 px-4 py-2 rounded-lg cursor-not-allowed border border-neutral/20">Previous</span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                        class="bg-background-secondary text-base px-4 py-2 rounded-lg border border-neutral/20 hover:bg-neutral/10 transition-colors duration-200">Previous</button>
                @endif
            </span>

            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if (
                            $page == $paginator->currentPage() ||
                                $page <= 2 ||
                                $page > $paginator->lastPage() - 2 ||
                                abs($paginator->currentPage() - $page) <= 1)
                            <span>
                                <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                    class="{{ $page === $paginator->currentPage() ? 'bg-primary text-base border-primary' : 'bg-background-secondary text-base border-neutral/20 hover:bg-neutral/10' }} px-4 py-2 rounded-lg cursor-pointer border transition-colors duration-200">{{ $page }}</button>
                            </span>
                        @elseif($page == 3 || $page == $paginator->lastPage() - 3)
                            <span
                                class="bg-background-secondary text-base px-4 py-2 rounded-lg border border-neutral/20">
                                <span>...</span>
                            </span>
                        @endif
                    @endforeach
                @else
                    <span class="bg-background-secondary text-base px-4 py-2 rounded-lg border border-neutral/20">
                        <span>...</span>
                    </span>
                @endif
            @endforeach

            <span>
                @if ($paginator->onLastPage())
                    <span
                        class="bg-neutral/10 text-base/50 px-4 py-2 rounded-lg cursor-not-allowed border border-neutral/20">Next</span>
                @else
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                        class="bg-background-secondary text-base px-4 py-2 rounded-lg border border-neutral/20 hover:bg-neutral/10 transition-colors duration-200">Next</button>
                @endif
            </span>
        </nav>
    @endif
</div>
