<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
        class="p-2 rounded-md hover:bg-neutral/10 transition-colors flex items-center justify-center"
        aria-label="Change currency">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span
            class="ml-1 text-xs font-medium">{{ \App\Models\Currency::find(session('currency', config('settings.default_currency')))?->code ?? session('currency', config('settings.default_currency')) }}</span>
    </button>

    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90" x-cloak style="z-index: 9999;"
        class="absolute right-0 mt-1 w-48 bg-background-secondary rounded-md shadow-xl border border-neutral/20 py-1">
        @foreach ($this->currencies as $currency)
            <button wire:click="changeCurrency('{{ $currency['value'] }}')" @click="open = false"
                class="block w-full text-left px-3 py-1.5 text-sm whitespace-nowrap hover:bg-primary/5 transition-colors {{ session('currency', config('settings.default_currency')) === $currency['value'] ? 'text-primary font-semibold bg-primary/5' : 'text-base hover:text-primary' }}">
                {{ $currency['label'] }}
            </button>
        @endforeach
    </div>
</div>
