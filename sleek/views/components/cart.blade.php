@if ($cartCount > 0)
    <div
        class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-primary/5 transition-colors duration-200 relative">
        <x-navigation.link :href="route('cart')" class="relative">
            <x-ri-shopping-bag-4-fill class="size-4 text-base/70 hover:text-primary transition-colors duration-200" />
            <div
                class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-base bg-primary rounded-full -top-1 -end-1">
                {{ $cartCount }}
            </div>
        </x-navigation.link>
    </div>
@endif
