<x-select wire:model.live="currentLocale" :options="collect($locales)
    ->map(
        fn($locale, $code) => [
            'value' => $code,
            'label' => $locale,
        ],
    )
    ->values()
    ->toArray()" placeholder="Select language" />

{{-- Custom dropdown version (disabled for now) --}}
{{--
<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open"
        class="p-2 rounded-md hover:bg-neutral/10 transition-colors flex items-center justify-center"
        aria-label="Change language"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
        </svg>
        <span class="ml-1 text-xs font-medium">{{ strtoupper(app()->getLocale()) }}</span>
    </button>
    
    <div 
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-150" 
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-90"
        x-cloak
        style="z-index: 9999;"
        class="absolute right-0 mt-1 w-48 bg-background-secondary rounded-md shadow-xl border border-neutral/20 py-1"
    >
        @foreach ($locales as $code => $locale)
            <button 
                wire:click="changeLocale('{{ $code }}')" 
                @click="open = false"
                class="block w-full text-left px-3 py-1.5 text-sm whitespace-nowrap hover:bg-primary/5 transition-colors {{ app()->getLocale() === $code ? 'text-primary font-semibold bg-primary/5' : 'text-base hover:text-primary' }}"
            >
                {{ $locale }}
            </button>
        @endforeach
    </div>
</div>
--}}
