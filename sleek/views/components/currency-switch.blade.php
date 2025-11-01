<x-select
    wire:model.live="currentCurrency"
    :options="$this->currencies"
    placeholder="Select currency"
    class="min-w-[120px] flex-shrink-0"
/>
